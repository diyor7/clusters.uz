<?php

namespace frontend\modules\cabinet\controllers;

use common\models\CompanyTransaction;
use common\models\Order;
use common\models\OrderRequest;
use common\models\User;
use frontend\controllers\FrontendController;
use frontend\models\RequestPriceForm;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class RequestController extends FrontendController
{
    public function beforeAction($action)
    {
        Order::checkTender();

        return parent::beforeAction($action);
    }

    private function getStatusCounts()
    {
        $counts = ArrayHelper::map((new Query)->select('status, count(*) as count')->from('order')->where(['company_id' => Yii::$app->user->identity->company_id, 'type' => Order::TYPE_TENDER])->groupBy('status')->all(), 'status', 'count');

        $categories = (new Query())->select("category_id")->from('product')->where(['product.company_id' => Yii::$app->user->identity->company_id])->groupBy("category_id")->all();

        $categories = ArrayHelper::getColumn($categories, 'category_id');

        $actives = Order::find()->joinWith("orderLists")->joinWith("orderLists.product")->where(['order.type' => Order::TYPE_TENDER]);

        $actives->andWhere(['in', 'order.status', [Order::STATUS_REQUESTING]]);

        $actives->andWhere([
            'or',
            ['in', 'product.category_id', $categories],
            ['order.company_id' => Yii::$app->user->identity->company_id]
        ]);

        $active_count = $actives->count();

        $counts[Order::STATUS_REQUESTING] = $active_count;

        $finisheds = Order::find()->join("LEFT JOIN", 'order_request', 'order.id = order_request.order_id and order_request.is_winner = 1')
            ->where(['order.type' => Order::TYPE_TENDER])
            ->andWhere([
                'or',
                ['order.company_id' => Yii::$app->user->identity->company_id],
                ['order_request.company_id' => Yii::$app->user->identity->company_id]
            ])->andWhere(['in', 'order.status', [Order::STATUS_SELECTED_PRODUCER]])->count();

        $counts[Order::STATUS_SELECTED_PRODUCER] = $finisheds;

        return $counts;
    }

    public function actionIndex()
    {
        $categories = (new Query())->select("category_id")->from('product')->where(['product.company_id' => Yii::$app->user->identity->company_id])->groupBy("category_id")->all();

        $categories = ArrayHelper::getColumn($categories, 'category_id');

        $orders = Order::find()->joinWith("orderLists")->joinWith("orderLists.product")->where([/*'order.company_id' => Yii::$app->user->identity->company_id,*/'order.type' => Order::TYPE_TENDER]);

        $orders->andWhere(['in', 'order.status', [Order::STATUS_REQUESTING]]);

        $orders->andWhere([
            'or',
            ['in', 'product.category_id', $categories],
            ['order.company_id' => Yii::$app->user->identity->company_id]
        ]);

        $orders->orderBy('order.id desc');

        $pages = new Pagination([
            'totalCount' => $orders->count(),
            'defaultPageSize' => 9
        ]);

        $orders->limit($pages->limit)->offset($pages->offset);

        $counts = $this->getStatusCounts();

        return $this->render('index', [
            'orders' => $orders->all(),
            'counts' => $counts,
            'pages' => $pages
        ]);
    }

    public function actionWaiting()
    {
        $orders = Order::find()->where(['company_id' => Yii::$app->user->identity->company_id, 'type' => Order::TYPE_TENDER]);

        $orders->andWhere(['in', 'status', [Order::STATUS_WAITING_ACCEPT]]);

        $orders->orderBy('id desc');

        $pages = new Pagination([
            'totalCount' => $orders->count(),
            'defaultPageSize' => 9
        ]);

        $orders->limit($pages->limit)->offset($pages->offset);

        $counts = $this->getStatusCounts();

        return $this->render('waiting', [
            'orders' => $orders->all(),
            'counts' => $counts,
            'pages' => $pages
        ]);
    }

    public function actionFinished()
    {
        $orders = Order::find()->join("LEFT JOIN", 'order_request', 'order.id = order_request.order_id and order_request.is_winner = 1')
            ->where(['order.type' => Order::TYPE_TENDER])
            ->andWhere([
                'or',
                ['order.company_id' => Yii::$app->user->identity->company_id],
                ['order_request.company_id' => Yii::$app->user->identity->company_id]
            ]);

        $orders->andWhere(['in', 'order.status', [Order::STATUS_SELECTED_PRODUCER]]);

        $orders->orderBy('order.id desc');

        $pages = new Pagination([
            'totalCount' => $orders->count(),
            'defaultPageSize' => 9
        ]);

        $orders->limit($pages->limit)->offset($pages->offset);

        $counts = $this->getStatusCounts();

        return $this->render('finished', [
            'orders' => $orders->all(),
            'counts' => $counts,
            'pages' => $pages
        ]);
    }

    public function actionCancelled()
    {
        $orders = Order::find()->where(['company_id' => Yii::$app->user->identity->company_id, 'type' => Order::TYPE_TENDER]);

        $orders->andWhere(['in', 'status', [Order::STATUS_CANCELLED_FROM_PRODUCER]]);

        $orders->orderBy('id desc');

        $pages = new Pagination([
            'totalCount' => $orders->count(),
            'defaultPageSize' => 9
        ]);

        $orders->limit($pages->limit)->offset($pages->offset);

        $counts = $this->getStatusCounts();

        return $this->render('cancelled', [
            'orders' => $orders->all(),
            'counts' => $counts,
            'pages' => $pages
        ]);
    }

    public function actionView($id)
    {
        $categories = (new Query())->select("category_id")->from('product')->where(['product.company_id' => Yii::$app->user->identity->company_id])->groupBy("category_id")->all();

        $categories = ArrayHelper::getColumn($categories, 'category_id');

        $order = Order::find()->joinWith("orderLists")->joinWith("orderLists.product")->where(['order.type' => Order::TYPE_TENDER, 'order.id' => $id]);

        $order = $order->andWhere([
            'or',
            ['in', 'product.category_id', $categories],
            ['order.company_id' => Yii::$app->user->identity->company_id]
        ])->one();

        if (!$order) throw new NotFoundHttpException(t("Страница не найдена"));

        $order_lists = $order->orderLists;

        $model = new RequestPriceForm;

        if ($model->load($_POST) && $model->validate()) {
            if (!Yii::$app->session->has("checked_key") || Yii::$app->session->has("checked_key") && Yii::$app->session->get("checked_key") == false) {
                Yii::$app->session->setFlash("danger", t("Не подтверждён ключом."));
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                Yii::$app->session->remove("checked_key");
            }

            if ($order->status == Order::STATUS_REQUESTING) { // tender boshlangan bo'sa
                if ($order->tender_end > date("Y-m-d H:i:s")) { // tender tugamangan bo'sa
                    if (!$order->myRequest) { // oldin taklif bermagan bo'lsa
                        if ($model->price * $order->getOrderLists()->sum("quantity") < ($order->total_sum)*0.98) { // taklif umumiy summadan 2%  past bo'lishi kerak

                            $user = User::findOne(Yii::$app->user->id);
                            $access_to_request = false; // taklifni qabul qilishga ruxsat

                            $zalog_transaction = CompanyTransaction::findOne([ // shu zapros bo'yicha oldin zalog olinganmi
                                'company_id' => Yii::$app->user->identity->company_id,
                                'status' => CompanyTransaction::STATUS_SUCCESS,
                                'type' => CompanyTransaction::TYPE_ZALOG,
                                'order_id' => $order->id
                            ]);

                            $kommision_block_transaction = CompanyTransaction::find()->where([ // shu zapros bo'yicha oldin zalog olinganmi
                                'company_id' => Yii::$app->user->identity->company_id,
                                'status' => CompanyTransaction::STATUS_SUCCESS,
                                'type' => CompanyTransaction::TYPE_BLOCK_COMMISION,
                                'order_id' => $order->id
                            ])->orderBy("id desc")->one();

                            $deposit_percentage = isset(Yii::$app->params['deposit_percentage']) ? Yii::$app->params['deposit_percentage'] : 3;
                            $commission_percentage = isset(Yii::$app->params['commission_percentage']) ? Yii::$app->params['commission_percentage'] : 0.15;

                            $zalog = $order->total_sum * $deposit_percentage / 100; // zalog bilan kommisiyani hisoblaymiz

                            $demping = false;

                            if ($model->price / $order->total_sum * 100 < 85) {
                                $zalog = $zalog + $order->total_sum - $model->price;
                                $demping = true;
                            }

                            $kommisiya = $model->price * $order->getOrderLists()->sum("quantity") * $commission_percentage / 100;

                            $zalog_plus_kommisiya = $zalog + $kommisiya;

                            if (!$zalog_transaction && !$kommision_block_transaction) { //agar oldin zalog va kom block to'lamagan bo'lsa
                                if ($user->availableBalance >= $zalog_plus_kommisiya) {
                                    $zalog_transaction = new CompanyTransaction([
                                        'company_id' => Yii::$app->user->identity->company_id,
                                        'status' => CompanyTransaction::STATUS_SUCCESS,
                                        'type' => CompanyTransaction::TYPE_ZALOG,
                                        'order_id' => $order->id,
                                        'currency' => $zalog,
                                        'description' => t("")
                                    ]);

                                    $kommision_block_transaction = new CompanyTransaction([
                                        'company_id' => Yii::$app->user->identity->company_id,
                                        'status' => CompanyTransaction::STATUS_SUCCESS,
                                        'type' => CompanyTransaction::TYPE_BLOCK_COMMISION,
                                        'order_id' => $order->id,
                                        'currency' => $kommisiya,
                                        'description' => t("")
                                    ]);

                                    if ($zalog_transaction->save() && $kommision_block_transaction->save()) {
                                        $access_to_request = true;

                                        Yii::$app->session->setFlash("info", t("С вашего баланса снято {zalog} сум в виде залога и {kommisiya} сум в виде комиссионой выплаты.", [
                                            'zalog' => showPrice($zalog),
                                            'kommisiya' => showPrice($kommisiya)
                                        ]));
                                    } else {
                                        $zalog_transaction->delete();
                                        $kommision_block_transaction->delete();

                                        Yii::$app->session->setFlash("danger", t("Не удалось снять деньги с вашего счёта. Пожалуйста, сообщите администрацию системы."));
                                    }
                                } else {
                                    Yii::$app->session->setFlash("danger", t("У вас недостаточно средств на вашем счете для этого предложения."));
                                }
                            } else {
                                if ($zalog_transaction && $demping) {
                                    if (($user->availableBalance + $zalog_transaction->currency) >= $zalog) {
                                        $revert_zalog_transaction = new CompanyTransaction([
                                            'company_id' => $zalog_transaction->company_id,
                                            'currency' => $zalog_transaction->currency,
                                            'order_id' => $zalog_transaction->order_id,
                                            'type' => CompanyTransaction::TYPE_REVERT_ZALOG,
                                            'status' => CompanyTransaction::STATUS_SUCCESS
                                        ]);

                                        if ($revert_zalog_transaction->save()) {
                                            $zalog_transaction->reverted_id = $revert_zalog_transaction->id;
                                            $zalog_transaction->save(false);

                                            $new_zalog_transaction = new CompanyTransaction([
                                                'company_id' => Yii::$app->user->identity->company_id,
                                                'status' => CompanyTransaction::STATUS_SUCCESS,
                                                'type' => CompanyTransaction::TYPE_ZALOG,
                                                'order_id' => $order->id,
                                                'currency' => $zalog,
                                                'description' => t("")
                                            ]);

                                            if ($new_zalog_transaction->save()) {
                                                $access_to_request = true;
                                            }
                                        }
                                    } else {
                                        Yii::$app->session->setFlash("danger", t("У вас недостаточно средств на вашем счете для этого предложения."));

                                        return $this->redirect(Yii::$app->request->referrer);
                                    }
                                }

                                // $kommision_block_transaction->currency = $kommisiya;
                                if ($kommision_block_transaction) {
                                    $kommision_block_transaction_revert = new CompanyTransaction([
                                        'company_id' => Yii::$app->user->identity->company_id,
                                        'status' => CompanyTransaction::STATUS_SUCCESS,
                                        'type' => CompanyTransaction::TYPE_REVERT_BLOCK_COMMISION,
                                        'order_id' => $order->id,
                                        'currency' => $kommision_block_transaction->currency,
                                        'description' => t("")
                                    ]);

                                    if ($kommision_block_transaction_revert->save()) {
                                        $kommision_block_transaction->reverted_id = $kommision_block_transaction_revert->id;
                                        $kommision_block_transaction->save(false);
                                    }
                                }

                                $kommision_block_transaction_new = new CompanyTransaction([
                                    'company_id' => Yii::$app->user->identity->company_id,
                                    'status' => CompanyTransaction::STATUS_SUCCESS,
                                    'type' => CompanyTransaction::TYPE_BLOCK_COMMISION,
                                    'order_id' => $order->id,
                                    'currency' => $kommisiya,
                                    'description' => t("")
                                ]);

                                if ($kommision_block_transaction_new->save()) {
                                    $access_to_request = true;
                                }
                            }

                            if ($access_to_request) {
                                $order_request = new OrderRequest([
                                    'company_id' => Yii::$app->user->identity->company_id,
                                    'price' => $model->price,
                                    'order_id' => $order->id,
                                    'is_winner' => 0
                                ]);

                                if ($order_request->save()) {
                                    Yii::$app->session->setFlash("success", t("Вы успешно сделали предложение"));

                                    return $this->redirect(Yii::$app->request->referrer);
                                } else {
                                    Yii::$app->session->setFlash("danger", t("Не удалось сделать предложение. Код: 001. Пожалуйста, сообщите администрацию системы."));
                                }
                            } else {
                                Yii::$app->session->setFlash("danger", t("Не удалось сделать предложение. Код: 002. Пожалуйста, сообщите администрацию системы."));
                            }
                        } else {
                            Yii::$app->session->setFlash("danger", t("Предложение не может быть выше стартовой суммы."));
                        }
                    } else {
                        Yii::$app->session->setFlash("danger", t("Вы уже сделали свое предложение."));
                    }
                } else {
                    Yii::$app->session->setFlash("danger", t("Поиск предложений уже закончен."));
                }
            } else {
                Yii::$app->session->setFlash("danger", t("Статус запроса не «Поиск предложений»."));
            }
        }

        return $this->render('view', [
            'order' => $order,
            'order_lists' => $order_lists,
            'model' => $model
        ]);
    }

    public function actionCancel($id)
    {
        $order = Order::findOne(['company_id' => Yii::$app->user->identity->company_id, 'type' => Order::TYPE_TENDER, 'id' => $id]);

        if (!$order) throw new NotFoundHttpException(t("Страница не найдена"));

        if (!Yii::$app->session->has("checked_key") || Yii::$app->session->has("checked_key") && Yii::$app->session->get("checked_key") == false) {
            Yii::$app->session->setFlash("danger", t("Не удалось принять запрос. Не подтверждён ключом."));
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            Yii::$app->session->remove("checked_key");
        }

        if ($order->status != Order::STATUS_WAITING_ACCEPT) {
            Yii::$app->session->setFlash("danger", t("Не удалось отказать запрос. Текущий статус запроса не равен на \"Ожидание подтверждения\"."));

            return $this->redirect(Yii::$app->request->referrer);
        }

        $customer_zalog = CompanyTransaction::findOne(['order_id' => $id, 'company_id' => Yii::$app->user->identity->company_id, 'type' => CompanyTransaction::TYPE_ZALOG]);

        $allright = true;

        if ($customer_zalog) {
            $revert_zalog = new CompanyTransaction([
                'company_id' => $customer_zalog->company_id,
                'currency' => $customer_zalog->currency,
                'order_id' => $customer_zalog->order_id,
                'type' => CompanyTransaction::TYPE_REVERT_ZALOG,
                'status' => CompanyTransaction::STATUS_SUCCESS
            ]);

            if ($revert_zalog->save()) {
                $customer_zalog->reverted_id = $revert_zalog->id;
                $allright *= $customer_zalog->save();
            }
        }

        $customer_komissiya = CompanyTransaction::findOne(['order_id' => $id, 'company_id' => Yii::$app->user->identity->company_id, 'type' => CompanyTransaction::TYPE_BLOCK_COMMISION]);

        if ($customer_komissiya) {
            $revert_komissiya = new CompanyTransaction([
                'company_id' => $customer_komissiya->company_id,
                'currency' => $customer_komissiya->currency,
                'order_id' => $customer_komissiya->order_id,
                'type' => CompanyTransaction::TYPE_REVERT_BLOCK_COMMISION,
                'status' => CompanyTransaction::STATUS_SUCCESS
            ]);

            if ($revert_komissiya->save()) {
                $customer_komissiya->reverted_id = $revert_komissiya->id;
                $allright *= $customer_komissiya->save();
            }
        }

        if ($allright) {
            $order->status = Order::STATUS_CANCELLED_FROM_PRODUCER;
            $order->cancel_date = date("Y-m-d H:i:s");
            $order->cancel_reason = t("Отказан от поставщика");

            if ($order->save()) {
                Yii::$app->session->setFlash("success", t("Вы успешно отказали запрос."));
                return $this->redirect(['index']);
            }
        }
    }

    public function actionAccept($id)
    {
        $order = Order::findOne(['company_id' => Yii::$app->user->identity->company_id, 'type' => Order::TYPE_TENDER, 'id' => $id]);

        if (!$order) throw new NotFoundHttpException(t("Страница не найдена"));

        if (!Yii::$app->session->has("checked_key") || Yii::$app->session->has("checked_key") && Yii::$app->session->get("checked_key") == false) {
            Yii::$app->session->setFlash("danger", t("Не удалось принять запрос. Не подтверждён ключом."));
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            Yii::$app->session->remove("checked_key");
        }

        if ($order->status != Order::STATUS_WAITING_ACCEPT) {
            Yii::$app->session->setFlash("danger", t("Не удалось принять запрос. Текущий статус запроса не равен на \"Ожидание подтверждения\"."));

            return $this->redirect(Yii::$app->request->referrer);
        }

        $user = User::findOne(Yii::$app->user->id);

        $deposit_percentage = isset(Yii::$app->params['deposit_percentage']) ? Yii::$app->params['deposit_percentage'] : 3;
        $commission_percentage = isset(Yii::$app->params['commission_percentage']) ? Yii::$app->params['commission_percentage'] : 0.15;

        $zalog =  $order->total_sum * ($deposit_percentage) / 100;
        $komissiya = $order->total_sum * ($commission_percentage) / 100;

        $zalog_plus_kommisiya = $zalog + $komissiya;

        if ($user->availableBalance < $zalog_plus_kommisiya) {
            Yii::$app->session->setFlash("danger", t("У вас недостаточно средств на вашем счете для принятия этого запроса."));

            return $this->redirect(Yii::$app->request->referrer);
        }

        $zalog_transaction = new CompanyTransaction([
            'company_id' => $user->company_id,
            'currency' => $zalog,
            'type' => CompanyTransaction::TYPE_ZALOG,
            'order_id' => $order->id,
            'description' => t(""),
            'status' => CompanyTransaction::STATUS_SUCCESS
        ]);

        $komissiya_transaction = new CompanyTransaction([
            'company_id' => $user->company_id,
            'currency' => $komissiya,
            'type' => CompanyTransaction::TYPE_BLOCK_COMMISION,
            'order_id' => $order->id,
            'description' => t(""),
            'status' => CompanyTransaction::STATUS_SUCCESS
        ]);

        if ($zalog_transaction->save() && $komissiya_transaction->save()) {
            Yii::$app->session->setFlash("info", t("С вашего баланса снято {zalog} сум в виде залога и {komissiya} в виде удержания комиссионного сбора.", [
                'zalog' => showPrice($zalog),
                'komissiya' => showPrice($komissiya)
            ]));

            $order->status = Order::STATUS_REQUESTING;
            $order->tender_end = date("Y-m-d H:i:s", strtotime("+48 hour"));

            if ($order->save()) {
                Yii::$app->session->setFlash("success", t("Вы успешно приняли запрос. Время окончания 48-часового торга: {date}.", [
                    "date" => date("d.m.Y H:i:s", strtotime($order->tender_end))
                ]));
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash("danger", t("Не удалось принять запрос. Пожалуйста, сообщите администрацию системы."));
                $zalog_transaction->delete();
                $komissiya_transaction->delete();
            }
        } else {
            Yii::$app->session->setFlash("danger", t("Не удалось снять деньги с вашего счёта. Пожалуйста, сообщите администрацию системы."));
            $zalog_transaction->delete();
            $komissiya_transaction->delete();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionMessage($order_id, $price)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $order = Order::find()->joinWith("orderLists")->joinWith("orderLists.product")->where(['order.type' => Order::TYPE_TENDER, 'order.id' => $order_id]);

        $categories = (new Query())->select("category_id")->from('product')->where(['product.company_id' => Yii::$app->user->identity->company_id])->groupBy("category_id")->all();

        $categories = ArrayHelper::getColumn($categories, 'category_id');

        $order = $order->andWhere([
            'or',
            ['in', 'product.category_id', $categories],
            ['order.company_id' => Yii::$app->user->identity->company_id]
        ])->one();

        if (!$order) throw new NotFoundHttpException(t("Страница не найдена"));

        if ($price < 0) {
            throw new BadRequestHttpException(t("Неверная цена"));
        }

        $deposit_percentage = isset(Yii::$app->params['deposit_percentage']) ? Yii::$app->params['deposit_percentage'] : 3;
        $commission_percentage = isset(Yii::$app->params['commission_percentage']) ? Yii::$app->params['commission_percentage'] : 0.15;

        $zalog = 0;

        if ($price / $order->total_sum * 100 < 85) {
            $zalog = $order->total_sum - $price;
        } else {
            $zalog = $order->total_sum * $deposit_percentage / 100; // zalog bilan kommisiyani hisoblaymiz
        }

        $kommisiya = $price * $order->getOrderLists()->sum("quantity") * $commission_percentage / 100;

        return [
            'message' => t("Вы точно хотите принять? Общая сумма: {total_sum} сум. Мы снимем с вашего баланса {currency} сум: {zalog} сум ({deposit_percentage}%) в виде залога от стартовой суммы и {kommisiya} сум ({commission_percentage}%) в виде комиссии от введенной суммы.", [
                'deposit_percentage' => $deposit_percentage,
                'commission_percentage' => $commission_percentage,
                'total_sum' => showPrice($price * $order->getOrderLists()->sum("quantity")),
                'currency' => showPrice($zalog + $kommisiya),
                'zalog' => showPrice($zalog),
                'kommisiya' => showPrice($kommisiya)
            ])
        ];
    }
}
