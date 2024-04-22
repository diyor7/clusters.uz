<?php

namespace frontend\modules\organisation\controllers;

use common\models\organisation\uzeltech\Category;
use common\models\organisation\uzeltech\Company;
use common\models\organisation\uzeltech\Product;
use common\models\organisation\uzeltech\ProductSearchByFilters;
use common\models\organisation\uzeltech\PdfProducts;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

/**
 * Default controller for the `store` module
 */
class UzeltechController extends Controller
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
    public function actionProductsAll($type = 0,$id = 1)
    {
        $products = PdfProducts::find()->all();
        $company = Company::findOne($id);

        return $this->render('pdf-products',[
            "products" => $products,
            "company" => $company,
            "type" => $type,
        ]);
    }

    public function actionProductSingle($section = 1, $id = 1)
    {
        $product = PdfProducts::find()->where(['section' => $section])->one();
        $company = Company::findOne($id);

        return $this->render('pdf-product',[
            "product" => $product,
            "section" => $section,
            "company" => $company,
        ]);
    }

    public function actionProducts($id = 1, $category_id = 1, $type = 0, $pageSize = 24, $order_by = 'id')
    {

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

    public function actionProduct($id = 1, $type = 0)
    {
        $product = Product::findOne($id);
        $company = Company::findOne($product->company_id);
        $category = Category::findOne($product->category_id);

        return $this->render('product',[
            "product" => $product,
            "company" => $company,
            "type" => $type,
            "category" => $category,
        ]);
    }

}
