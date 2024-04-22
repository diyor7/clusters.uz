<?php

namespace frontend\modules\user\controllers;

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
        $orders = Order::find()->where(['user_id' => Yii::$app->user->id]);

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

        $active_count = Order::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['not in', 'status', [Order::STATUS_FINISHED, Order::STATUS_CANCELLED]])->count();
        $finished_count = Order::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['in', 'status', [Order::STATUS_FINISHED, Order::STATUS_CANCELLED]])->count();

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
        $order = Order::findOne(['user_id' => Yii::$app->user->id, 'id' => $id]);

        if (!$order) throw new NotFoundHttpException(t("Страница не найдена"));

        $order_lists = $order->orderLists;

        $active_count = Order::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['not in', 'status', [Order::STATUS_FINISHED, Order::STATUS_CANCELLED]])->count();
        $finished_count = Order::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['in', 'status', [Order::STATUS_FINISHED, Order::STATUS_CANCELLED]])->count();

        return $this->render('view', [
            'order' => $order,
            'active_count' => $active_count,
            'finished_count' => $finished_count,
            'order_lists' => $order_lists
        ]);
    }
}
