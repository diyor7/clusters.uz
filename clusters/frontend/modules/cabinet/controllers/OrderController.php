<?php

namespace frontend\modules\cabinet\controllers;

use common\models\Notification;
use common\models\Order;
use common\models\OrderList;
use common\models\User;
use frontend\controllers\FrontendController;
use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class OrderController extends FrontendController
{
    public function actionIndex($status = null)
    {
        $orders = Order::find()->where(['company_id' => Yii::$app->user->identity->company_id, 'type' => Order::TYPE_GENERAL]);

        if ($status == "finished") {
            $orders->andWhere(['in', 'status', [Order::STATUS_FINISHED, Order::STATUS_CANCELLED]]);
        } else {
            $orders->andWhere(['not in', 'status', [Order::STATUS_FINISHED, Order::STATUS_CANCELLED]]);
        }

        $orders->orderBy('id desc');

        $pages = new Pagination([
            'totalCount' => $orders->count(),
            'defaultPageSize' => 9
        ]);

        $orders->limit($pages->limit)->offset($pages->offset);

        $active_count = Order::find()->where(['company_id' => Yii::$app->user->identity->company_id, 'type' => Order::TYPE_GENERAL])->andWhere(['not in', 'status', [Order::STATUS_FINISHED, Order::STATUS_CANCELLED]])->count();
        $finished_count = Order::find()->where(['company_id' => Yii::$app->user->identity->company_id, 'type' => Order::TYPE_GENERAL])->andWhere(['in', 'status', [Order::STATUS_FINISHED, Order::STATUS_CANCELLED]])->count();

        return $this->render('index', [
            'orders' => $orders->all(),
            'status' => $status,
            'active_count' => $active_count,
            'finished_count' => $finished_count,
            'pages' => $pages
        ]);
    }

    public function actionView($id)
    {
        $order = Order::findOne(['company_id' => Yii::$app->user->identity->company_id, 'id' => $id, 'type' => Order::TYPE_GENERAL]);

        if (!$order) throw new NotFoundHttpException(t("Страница не найдена"));

        $order_lists = $order->orderLists;

        return $this->render('view', [
            'order' => $order,
            'order_lists' => $order_lists
        ]);
    }

    public function actionDelete($id)
    {
        $order = Order::findOne(['company_id' => Yii::$app->user->identity->company_id, 'id' => $id]);

        if (!$order) throw new NotFoundHttpException(t("Страница не найдена"));

        $order->delete();

        Yii::$app->session->setFlash("success", t("Заказ успешно удалён."));

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUpdate($id)
    {
        $order = Order::findOne(['company_id' => Yii::$app->user->identity->company_id, 'id' => $id]);

        if (!$order) throw new NotFoundHttpException(t("Страница не найдена"));

        if (isset($_POST['Order']) && isset($_POST['Order']['status']) && array_key_exists($_POST['Order']['status'], Order::getStatuses())) {
            $order->status = $_POST['Order']['status'];

            if ($order->save(false)) {
                if ($order->status == Order::STATUS_FINISHED || $order->status == Order::STATUS_CANCELLED) {

                    Notification::deleteAll(['and', ['user_id' => $order->user_id, 'order_id' => $order->id], ['!=', 'type', $order->status]]);

                    if (!Notification::findOne(['user_id' => $order->user_id, 'order_id' => $order->id, 'type' => $order->status])) {
                        $notification = new Notification([
                            'order_id' => $order->id,
                            'user_id' => $order->user_id,
                            'type' => $order->status,
                            'created_at' => date("Y-m-d H:i:s")
                        ]);

                        $notification->save();
                    }
                }

                Yii::$app->session->setFlash('success', t("Заказ успешно сохранён."));

                return $this->redirect(['/cabinet/order']);
            }
        }

        return $this->render("update", [
            'order' => $order
        ]);
    }
}
