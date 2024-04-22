<?php

namespace frontend\modules\cabinet\controllers;

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
        $models = Contract::find()->where(['producer_id' => Yii::$app->user->identity->company_id, 'status' => Contract::STATUS_CREATED])->all();

        $counts = $this->getStatusCounts();

        return $this->render('index', [
            'models' => $models,
            'counts' => $counts
        ]);
    }

    public function actionWaiting()
    {
        $models = Contract::find()->where(['producer_id' => Yii::$app->user->identity->company_id, 'status' => Contract::STATUS_WAITING_PAYMENT_FROM_CUSTOMER])->all();

        $counts = $this->getStatusCounts();

        return $this->render('waiting', [
            'models' => $models,
            'counts' => $counts
        ]);
    }

    public function actionProcessing()
    {
        $models = Contract::find()->where(['producer_id' => Yii::$app->user->identity->company_id, 'status' => Contract::STATUS_PROCESSING])->all();

        $counts = $this->getStatusCounts();

        return $this->render('processing', [
            'models' => $models,
            'counts' => $counts
        ]);
    }

    public function actionDelivered()
    {
        $models = Contract::find()->where(['producer_id' => Yii::$app->user->identity->company_id, 'status' => Contract::STATUS_DELIVERED])->all();

        $counts = $this->getStatusCounts();

        return $this->render('delivered', [
            'models' => $models,
            'counts' => $counts
        ]);
    }

    public function actionCancelled()
    {
        $models = Contract::find()->where(['producer_id' => Yii::$app->user->identity->company_id, 'status' => Contract::STATUS_CANCELLED])->all();

        $counts = $this->getStatusCounts();

        return $this->render('cancelled', [
            'models' => $models,
            'counts' => $counts
        ]);
    }

    public function actionView($id)
    {
        $model = Contract::findOne(['id' => $id, 'producer_id' => Yii::$app->user->identity->company_id]);

        if (!$model) throw new NotFoundHttpException(t("Договор не найден."));

        return $this->render("view", [
            'model' => $model
        ]);
    }

    public function actionPdf($id)
    {
        $model = Contract::findOne(['id' => $id, 'producer_id' => Yii::$app->user->identity->company_id]);

        if (!$model) throw new NotFoundHttpException(t("Договор не найден."));

        $options = new \Dompdf\Options([
            'isHtml5ParserEnabled' => true,
        ]);

        $options->setIsRemoteEnabled(true);
        $options->setIsPhpEnabled(true);

        $dompdf = new Dompdf($options);
        if($model->order_id){
            $dompdf->loadHtml($this->renderPartial('pdf', [
                'model' => $model
            ]));
        } else {
            $dompdf->loadHtml($this->renderPartial('pdf_auction', [
                'model' => $model
            ]));
        }

        $dompdf->setPaper('A4', 'portait');

        $dompdf->render();

        $filename = t("Договор №{number} от {date}", ['number' => $model->id, 'date' => date("d.m.Y", strtotime($model->created_at))]);

        \Yii::$app->response->headers->add('Filename', $filename);

        $dompdf->stream($filename);
    }

    public function actionAccept($id)
    {
        $model = Contract::findOne(['id' => $id, 'producer_id' => Yii::$app->user->identity->company_id]);

        if (!$model) throw new NotFoundHttpException(t("Договор не найден."));

        if (!Yii::$app->session->has("checked_key") || Yii::$app->session->has("checked_key") && Yii::$app->session->get("checked_key") == false) {
            Yii::$app->session->setFlash("danger", t("Не подтверждён ключом."));
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            Yii::$app->session->remove("checked_key");
        }

        if ($model->status == Contract::STATUS_CREATED) {
            $model->producer_signed = 1;
            $model->producer_sign_date = date("Y-m-d H:i:s");

            if ($model->save()) {
                Yii::$app->session->setFlash("success", t("Вы успешно подписали договор."));

                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        Yii::$app->session->setFlash('danger', t("Вы не можете подписать этот договор."));

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionCancel($id)
    {
        $model = Contract::findOne(['id' => $id, 'producer_id' => Yii::$app->user->identity->company_id]);

        if (!$model) throw new NotFoundHttpException(t("Договор не найден."));

        if (!Yii::$app->session->has("checked_key") || Yii::$app->session->has("checked_key") && Yii::$app->session->get("checked_key") == false) {
            Yii::$app->session->setFlash("danger", t("Не подтверждён ключом."));
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            Yii::$app->session->remove("checked_key");
        }

        $model->status = Contract::STATUS_CANCELLED;
        $model->producer_cancel_date = date("Y-m-d H:i:s");

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

    private function getStatusCounts()
    {
        return ArrayHelper::map((new Query())->select('status, count(*) as count')->from('contract')->where(['producer_id' => Yii::$app->user->identity->company_id])->groupBy('status')->all(), 'status', 'count');
    }
}
