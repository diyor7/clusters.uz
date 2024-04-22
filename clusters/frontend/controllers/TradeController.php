<?php

namespace frontend\controllers;

use common\models\CompanyTransaction;
use common\models\Order;
use common\models\OrderRequest;
use common\models\User;
use frontend\models\RequestPriceForm;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class TradeController extends Controller
{
    public function actionIndex()
    {
        $orders = Order::find()->join("LEFT JOIN", 'order_request', 'order.id = order_request.order_id and order_request.is_winner = 1')
            ->where(['order.type' => Order::TYPE_TENDER]);

        $orders->andWhere(['in', 'order.status', [Order::STATUS_SELECTED_PRODUCER]]);

        $orders->orderBy('order.id desc');

        $pages = new Pagination([
            'totalCount' => $orders->count(),
            'defaultPageSize' => 20
        ]);

        $orders->limit($pages->limit)->offset($pages->offset);

        return $this->render('index', [
            'orders' => $orders->all(),
            'pages' => $pages
        ]);
    }


    public function actionView($id)
    {
        $order = Order::find()->joinWith("orderLists")->joinWith("orderLists.product")->where(['order.type' => Order::TYPE_TENDER, 'order.id' => $id, 'order.status' => Order::STATUS_SELECTED_PRODUCER]);

        $order = $order->one();

        if (!$order) throw new NotFoundHttpException(t("Страница не найдена"));

        $order_lists = $order->orderLists;

        return $this->render('view', [
            'order' => $order,
            'order_lists' => $order_lists,
        ]);
    }
}
