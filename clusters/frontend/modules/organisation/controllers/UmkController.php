<?php

namespace frontend\modules\organisation\controllers;

use common\models\organisation\umk\Category;
use common\models\organisation\umk\Company;
use common\models\organisation\umk\Product;
use common\models\organisation\umk\ProductSearchByFilters;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

/**
 * Default controller for the `store` module
 */
class UmkController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($type = 0, $id = 1)
    {
//        $this->layout = '/organisation/agmk';
        $company = Company::findOne(9);
        $categories = Category::find()->where(['id' => 1])->all();

//        if($type == 1) $this->redirect(["/organisation/umk/products", 'id' => 9, 'type' => 1, 'category_id' => 5]);

        return $this->render('index',[
            "company" => $company,
            "categories" => $categories,
            'products' => $company->products,
            "type" => $type,
        ]);
    }

    public function actionProducts($id = 9, $category_id = 5, $type = 0, $pageSize = 24, $order_by = 'id')
    {

        $company = Company::findOne(9);
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

    public function actionNeeds($company_id = 9)
    {
        $searchModel = new ProductSearchByFilters();
        $dataProvider = $searchModel->searchByCompany(\Yii::$app->request->queryParams,  $company_id, 0);
        $company = Company::findOne($company_id);
        $category = Category::findOne(5);

        return $this->render('needs',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            "category" => $category,
            "type" => 0,
            "company" => $company,
        ]);
    }

    public function actionProduct($id = 1, $type = 0)
    {

        $product = Product::findOne($id);
        $company = Company::findOne($product->company_id);
        $category = Category::findOne($product->category_id);

        return $this->render($type==0?'need_product':'product',[
            "product" => $product,
            "company" => $company,
            "type" => $type,
            "category" => $category,
        ]);
    }

}
