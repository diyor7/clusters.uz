<?php

namespace frontend\modules\organisation\controllers;

use common\models\Category;
use common\models\Order;
use common\models\organisation\agmk\Company;
use common\models\Product;
use frontend\controllers\FrontendController;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class ProductController extends FrontendController
{
    public function actionImport()
    {
        $this->layout = '/organisation/agmk';
        $id = 1;
        $cookies = \Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => 'main_company_id',
            'value' => $id,
        ]));

        $company = Company::findOne($id);

        return $this->render('index',[
            "company" => $company,
            'products' => $company->products,
            "type" => 0,
        ]);
    }
    public function actionView($url, $id, $delivery_tab = null)
    {
        $product = Product::findOne(['id' => $id, 'status' => Product::STATUS_ACTIVE]);

        if (!$product) {
            throw new NotFoundHttpException(t("Страница не найдена"));
        }

        $users_buyed = Order::find()->joinWith("orderLists")->where(['order_list.product_id' => $product->id, 'order.status' => Order::STATUS_FINISHED])->groupBy('order.user_id')->count();

        $related = Product::find()->joinWith("productTranslates")->where(['category_id' => $product->category_id, 'status' => Product::STATUS_ACTIVE])->orderBy('id desc')->limit(6)->all();

        return $this->render("view", [
            'product' => $product,
            'users_buyed' => $users_buyed,
            'delivery_tab' => $delivery_tab,
            'related' => $related
        ]);
    }
}
