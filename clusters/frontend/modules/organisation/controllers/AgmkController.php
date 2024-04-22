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
class AgmkController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($type = 0, $id = 1)
    {
//        $this->layout = '/organisation/agmk';
        $company = Company::findOne($id);

        return $this->render('index',[
            "company" => $company,
            'products' => $company->products,
            "type" => $type,
        ]);
    }

    public function actionProducts($id = 1, $category_id = 1, $type = 0, $pageSize = 24, $order_by = 'id')
    {
        $company = Company::findOne($id);
        $category = Category::findOne($category_id);
        $companies = Company::find()->select('id')->where(['status' => 1, 'parent_id' => $company->id])->orWhere(['id' => $company->id])->groupBy('id');

        $searchModel = new ProductSearchByFilters();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, $category_id, $companies, $type);

        return $this->render($type == 1?'products':'needs',[
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

        return $this->render($type==0?'need_product':'product',[
            "product" => $product,
            "company" => $company,
            "type" => $type,
            "category" => $category,
        ]);
    }

}
