<?php

namespace frontend\modules\organisation\controllers;

use common\models\organisation\agmk\Category;
use common\models\organisation\agmk\Company;
use common\models\organisation\agmk\Product;
use common\models\organisation\agmk\ProductSearchByFilters;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

/**
 * Default controller for the `store` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($type = 0, $id = 1)
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
            "type" => $type,
        ]);
    }

    public function actionProducts($id, $category_id, $type = 0, $pageSize = 24, $order_by = 'id')
    {
        $cookies = \Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => 'main_company_id',
            'value' => $id,
        ]));

        $company = Company::findOne($id);
        $category = Category::findOne($category_id);
        $companies = Company::find()->select('id')->where(['status' => 1, 'parent_id' => $company->id])->orWhere(['id' => $company->id])->groupBy('id');

        $searchModel = new ProductSearchByFilters();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, $category_id, $companies, $type);

        return $this->render('products',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            "company" => $company,
            "category" => $category,
            "type" => $type,
        ]);
    }

    public function actionProduct($id, $type = 0)
    {

        $product = Product::findOne($id);
        $company = Company::findOne($product->company_id);
        $category = Category::findOne($product->category_id);
        $cookies = \Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => 'main_company_id',
            'value' => $product->company_id,
        ]));

        return $this->render('product',[
            "product" => $product,
            "company" => $company,
            "type" => $type,
            "category" => $category,
        ]);
    }

}
