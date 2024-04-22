<?php

namespace frontend\modules\user\controllers;

use common\models\Company;
use common\models\CompanyTransaction;
use common\models\Contract;
use common\models\User;
use Dompdf\Dompdf;
use frontend\controllers\FrontendController;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class ContractController extends FrontendController
{

    public function actionIndex()
    {
        return $this->redirect(['waiting']);

        $models = Contract::find()->where(['customer_id' => Yii::$app->user->identity->company_id, 'status' => Contract::STATUS_CREATED])->all();

        $counts = $this->getStatusCounts();

        return $this->render('index', [
            'models' => $models,
            'counts' => $counts
        ]);
    }

    public function actionWaiting()
    {
        $models = Contract::find()->where(['customer_id' => Yii::$app->user->identity->company_id, 'status' => Contract::STATUS_WAITING_PAYMENT_FROM_CUSTOMER])->all();

        $counts = $this->getStatusCounts();

        return $this->render('waiting', [
            'models' => $models,
            'counts' => $counts
        ]);
    }

    public function actionProcessing()
    {
        $models = Contract::find()->where(['customer_id' => Yii::$app->user->identity->company_id, 'status' => Contract::STATUS_PROCESSING])->all();

        $counts = $this->getStatusCounts();

        return $this->render('processing', [
            'models' => $models,
            'counts' => $counts
        ]);
    }

    public function actionDelivered()
    {
        $models = Contract::find()->where(['customer_id' => Yii::$app->user->identity->company_id, 'status' => Contract::STATUS_DELIVERED])->all();

        $counts = $this->getStatusCounts();

        return $this->render('delivered', [
            'models' => $models,
            'counts' => $counts
        ]);
    }

    public function actionCancelled()
    {
        $models = Contract::find()->where(['customer_id' => Yii::$app->user->identity->company_id, 'status' => Contract::STATUS_CANCELLED])->all();

        $counts = $this->getStatusCounts();

        return $this->render('cancelled', [
            'models' => $models,
            'counts' => $counts
        ]);
    }

    public function actionView($id)
    {
        $model = Contract::findOne(['id' => $id, 'customer_id' => Yii::$app->user->identity->company_id]);

        if (!$model) throw new NotFoundHttpException(t("Договор не найден."));

        return $this->render("view", [
            'model' => $model
        ]);
    }

    public function actionAccept($id)
    {
        $model = Contract::findOne(['id' => $id, 'customer_id' => Yii::$app->user->identity->company_id]);

        if (!$model) throw new NotFoundHttpException(t("Договор не найден"));

        if ($model->customer) {
            if (!Yii::$app->session->has("checked_key") || Yii::$app->session->has("checked_key") && Yii::$app->session->get("checked_key") == false) {
                Yii::$app->session->setFlash("danger", t("Не подтверждён ключом."));
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                Yii::$app->session->remove("checked_key");
            }
        }

        if ($model->status == Contract::STATUS_CREATED) {
            $model->customer_signed = 1;
            $model->customer_sign_date = date("Y-m-d H:i:s");

            if ($model->save()) {
                Yii::$app->session->setFlash("success", t("Вы успешно подписали договор."));

                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        Yii::$app->session->setFlash('danger', t("Вы не можете подписать этот договор."));

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionMarkDelivered($id)
    {
        $model = Contract::findOne(['id' => $id, 'customer_id' => Yii::$app->user->identity->company_id]);

        if (!$model) throw new NotFoundHttpException(t("Договор не найден"));

        if ($model->customer) {
            if (!Yii::$app->session->has("checked_key") || Yii::$app->session->has("checked_key") && Yii::$app->session->get("checked_key") == false) {
                Yii::$app->session->setFlash("danger", t("Не подтверждён ключом."));
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                Yii::$app->session->remove("checked_key");
            }
        }

        if ($model->status == Contract::STATUS_PROCESSING) {
            $transaction = Yii::$app->db->beginTransaction();
            $allright = true;

            $customer = User::findOne(Yii::$app->user->id);

            $rkp = CompanyTransaction::findOne([
                'company_id' =>  $model->customer_id,
                'contract_id' => $model->id,
                'type' => CompanyTransaction::TYPE_RKP,
                'status' => CompanyTransaction::STATUS_SUCCESS
            ]);

            if ($rkp) {
                $rkp_back = new CompanyTransaction([
                    'company_id' =>  $model->customer_id,
                    'currency' => $rkp->currency,
                    'contract_id' => $model->id,
                    'type' => CompanyTransaction::TYPE_BACK_RKP,
                    'status' => CompanyTransaction::STATUS_SUCCESS
                ]);
                $allright *= $rkp_back->save();
                $rkp->reverted_id = $rkp_back->id;
                $rkp->save(false);
            }

            $deposit_customer = CompanyTransaction::findOne(['order_id' => $model->order_id, 'type' => CompanyTransaction::TYPE_ZALOG, 'company_id' => $model->customer_id]);

            if ($deposit_customer) {
                $revert_deposit_customer = new CompanyTransaction([
                    'company_id' => $model->customer_id,
                    'currency' => $deposit_customer->currency,
                    'type' => CompanyTransaction::TYPE_REVERT_ZALOG,
                    'status' => CompanyTransaction::STATUS_SUCCESS,
                    'order_id' => $model->order_id,
                    'description' => t("")
                ]);

                $allright *= $revert_deposit_customer->save();
                $deposit_customer->reverted_id = $revert_deposit_customer->id;
                $deposit_customer->save(false);
            }

            $deposit_producer = CompanyTransaction::findOne(['order_id' => $model->order_id, 'type' => CompanyTransaction::TYPE_ZALOG, 'company_id' => $model->producer_id]);

            if ($deposit_producer) {
                $revert_deposit_producer = new CompanyTransaction([
                    'company_id' => $model->producer_id,
                    'currency' => $deposit_producer->currency,
                    'type' => CompanyTransaction::TYPE_REVERT_ZALOG,
                    'status' => CompanyTransaction::STATUS_SUCCESS,
                    'order_id' => $model->order_id,
                    'description' => t("")
                ]);

                $allright *= $revert_deposit_producer->save();
                $deposit_producer->reverted_id = $revert_deposit_producer->id;
                $deposit_producer->save(false);
            }

            // $commission_percentage = isset(Yii::$app->params['commission_percentage']) ? Yii::$app->params['commission_percentage'] : 0.15;

            // $commision = $model->price * $commission_percentage / 100;

            $customer_available_balance = $customer->availableBalance;

            if ($customer->companyType == Company::TYPE_COPERATE) {
                if ($customer_available_balance >= $model->price) {
                    $pay_to_contract = new CompanyTransaction([
                        'company_id' => $model->customer_id,
                        'currency' => $model->price,
                        'contract_id' => $model->id,
                        'type' => CompanyTransaction::TYPE_PAY_TO_CONTRACT,
                        'status' => CompanyTransaction::STATUS_SUCCESS
                    ]);

                    $from_contract = new CompanyTransaction([
                        'company_id' => $model->producer_id,
                        'currency' => $model->price,
                        'contract_id' => $model->id,
                        'type' => CompanyTransaction::TYPE_PAYED_FROM_CONTRACT,
                        'status' => CompanyTransaction::STATUS_SUCCESS
                    ]);

                    $allright *= $pay_to_contract->save();
                    $allright *= $from_contract->save();
                }
            }

            $model->status = Contract::STATUS_DELIVERED;
            $model->customer_mark_delivered_date = date("Y-m-d H:i:s");

            $allright *= $model->save();

            if ($allright) {
                Yii::$app->session->setFlash("success", t("Вы успешно закрыли договор №{contract_number} от {date}.", [
                    'contract_number' => $model->id,
                    'date' => date("d.m.Y", strtotime($model->created_at))
                ]));

                $transaction->commit();

                return $this->redirect(Yii::$app->request->referrer);
            } else {
                Yii::$app->session->setFlash('danger', t("Вы не можете завершить этот договор."));
            }

            $transaction->rollBack();
        }

        Yii::$app->session->setFlash('danger', t("Вы не можете завершить этот договор."));

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionPay($id)
    {
        $model = Contract::findOne(['id' => $id, 'customer_id' => Yii::$app->user->identity->company_id]);

        if (!$model) throw new NotFoundHttpException(t("Договор не найден"));

        if ($model->customer) {
            if (!Yii::$app->session->has("checked_key") || Yii::$app->session->has("checked_key") && Yii::$app->session->get("checked_key") == false) {
                Yii::$app->session->setFlash("danger", t("Не подтверждён ключом."));
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                Yii::$app->session->remove("checked_key");
            }
        }

        if ($model->status == Contract::STATUS_WAITING_PAYMENT_FROM_CUSTOMER) {
            $transaction = Yii::$app->db->beginTransaction();

            $user = User::findOne(Yii::$app->user->id);

            if ($user->companyType == Company::TYPE_COPERATE) {
                if ($user->availableBalance >= $model->price) {
                    $rkp = new CompanyTransaction([
                        'company_id' => $user->company_id,
                        'currency' => $model->price,
                        'contract_id' => $model->id,
                        'type' => CompanyTransaction::TYPE_RKP,
                        'status' => CompanyTransaction::STATUS_SUCCESS
                    ]);

                    if ($rkp->save()) {
                        Yii::$app->session->setFlash("info", t("Вы успешно оплатили в РКП по договору №{contract_number} от {date}.", [
                            'contract_number' => $model->id,
                            'date' => date("d.m.Y", strtotime($model->created_at))
                        ]));
                    } else {
                        Yii::$app->session->setFlash('danger', t("Не удалось оплатить в РКП по договору."));
                        $transaction->rollBack();
                        return $this->redirect(Yii::$app->request->referrer);
                    }
                } else {
                    Yii::$app->session->setFlash('danger', t("У вас недостаточное средство, пополните баланс."));
                    return $this->redirect(Yii::$app->request->referrer);
                }
            }

            $model->status = Contract::STATUS_PROCESSING;
            $model->customer_pay_date = date("Y-m-d H:i:s");

            if ($model->save()) {
                $transaction->commit();

                Yii::$app->session->setFlash('success', t("Статус договора успешно изменён."));

                return $this->redirect(Yii::$app->request->referrer);
            } else {
                $transaction->rollBack();
            }
        } else {
            Yii::$app->session->setFlash('danger', t("Вы не можете оплатит по этому договору."));
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionCancel($id)
    {
        $model = Contract::findOne(['id' => $id, 'customer_id' => Yii::$app->user->identity->company_id]);

        if (!$model) throw new NotFoundHttpException(t("Договор не найден"));

        if ($model->customer) {
            if (!Yii::$app->session->has("checked_key") || Yii::$app->session->has("checked_key") && Yii::$app->session->get("checked_key") == false) {
                Yii::$app->session->setFlash("danger", t("Не подтверждён ключом."));
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        $model->status = Contract::STATUS_CANCELLED;
        $model->customer_cancel_date = date("Y-m-d H:i:s");

        if ($model->customer) {
            if (!Yii::$app->session->has("checked_key") || Yii::$app->session->has("checked_key") && Yii::$app->session->get("checked_key") == false) {
                Yii::$app->session->setFlash("danger", t("Не подтверждён ключом."));
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        if ($model->save()) {
            Yii::$app->session->setFlash("success", t("Вы расторгнули договор."));

            // $producer_transaction = CompanyTransaction::findOne(['company_id' => $model->producer_id, 'order_id' => $model->order_id, 'type' => CompanyTransaction::TYPE_DEPOSIT]);

            // if ($producer_transaction) {
            //     $revert = new CompanyTransaction([
            //         'company_id' => $producer_transaction->company_id,
            //         'currency' => $producer_transaction->currency,
            //         'order_id' => $producer_transaction->order_id,
            //         'type' => CompanyTransaction::TYPE_REVERT
            //     ]);

            //     $revert->save();
            // }

            // $customer_transaction = CompanyTransaction::findOne(['company_id' => $model->customer_id, 'order_id' => $model->order_id, 'type' => CompanyTransaction::TYPE_DEPOSIT]);

            // if ($customer_transaction) {
            //     $revert = new CompanyTransaction([
            //         'company_id' => $customer_transaction->company_id,
            //         'currency' => $customer_transaction->currency,
            //         'order_id' => $customer_transaction->order_id,
            //         'type' => CompanyTransaction::TYPE_REVERT
            //     ]);

            //     $revert->save();
            // }

            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionPdf($id)
    {
        $model = Contract::findOne(['id' => $id, 'customer_id' => Yii::$app->user->identity->company_id]);

        if (!$model) throw new NotFoundHttpException(t("Договор не найден."));

        $options = new \Dompdf\Options([
            'isHtml5ParserEnabled' => true,
        ]);

        $options->setIsRemoteEnabled(true);
        $options->setIsPhpEnabled(true);

        $dompdf = new Dompdf($options);

        if($model->order){
            $dompdf->loadHtml($this->renderPartial('../../../cabinet/views/contract/pdf', [
                'model' => $model
            ]));
        } else {
            $dompdf->loadHtml($this->renderPartial('../../../cabinet/views/contract/pdf_auction', [
                'model' => $model
            ]));
        }
        

        $dompdf->setPaper('A4', 'portait');

        $dompdf->render();

        $filename = t("Договор №{number} от {date}", ['number' => $model->id, 'date' => date("d.m.Y", strtotime($model->created_at))]);

        \Yii::$app->response->headers->add('Filename', $filename);

        $dompdf->stream($filename);
    }


    private function getStatusCounts()
    {
        return ArrayHelper::map((new Query())->select('status, count(*) as count')->from('contract')->where(['customer_id' => Yii::$app->user->identity->company_id])->groupBy('status')->all(), 'status', 'count');
    }
}
