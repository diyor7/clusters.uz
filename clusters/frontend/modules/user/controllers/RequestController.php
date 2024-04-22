<?php

namespace frontend\modules\user\controllers;

use common\models\Order;
use frontend\controllers\FrontendController;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class RequestController extends FrontendController
{
    public function beforeAction($action)
    {
        Order::checkTender();
        
        return parent::beforeAction($action);
    }

    private function getStatusCounts()
    {
        return ArrayHelper::map((new Query)->select('status, count(*) as count')->from('order')->where(['user_id' => Yii::$app->user->id, 'type' => Order::TYPE_TENDER])->groupBy('status')->all(), 'status', 'count');
    }

    public function actionIndex()
    {
        $orders = Order::find()->where(['user_id' => Yii::$app->user->id, 'type' => Order::TYPE_TENDER]);

        $orders->andWhere(['in', 'status', [Order::STATUS_REQUESTING]]);

        $orders->orderBy('id desc');

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
        $orders = Order::find()->where(['user_id' => Yii::$app->user->id, 'type' => Order::TYPE_TENDER]);

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
        $orders = Order::find()->where(['user_id' => Yii::$app->user->id, 'type' => Order::TYPE_TENDER]);

        $orders->andWhere(['in', 'status', [Order::STATUS_SELECTED_PRODUCER]]);

        $orders->orderBy('id desc');

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
        $orders = Order::find()->where(['user_id' => Yii::$app->user->id, 'type' => Order::TYPE_TENDER]);

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
        $order = Order::findOne(['user_id' => Yii::$app->user->id, 'type' => Order::TYPE_TENDER, 'id' => $id]);

        if (!$order) throw new NotFoundHttpException(t("Страница не найдена"));

        $order_lists = $order->orderLists;

        return $this->render('view', [
            'order' => $order,
            'order_lists' => $order_lists,
        ]);
    }
}
