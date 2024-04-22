<?php

namespace frontend\modules\store\controllers;

use common\models\Category;
use common\models\Company;
use frontend\controllers\FrontendController;

class CategoryController extends FrontendController
{
    public function actionIndex($company_id = null)
    {
        // $categories = Category::getProductsWithCount();

        $company = Company::findOne($company_id);

        $models = [];

        $models = Category::find()
            ->join("LEFT JOIN", "category_translate", "category.id = category_translate.category_id and category_translate.lang = :lang", [':lang' => \Yii::$app->languageId->id])
            ->select(['category.*, (select count(*) from product where (product.category_id = category.id or product.category_id in (select id from category c where c.parent_id = category.id)) and product.status = 1) as product_count'])
            ->where('parent_id is null and category.type = 3')->orderBy('category_translate.title asc, product_count desc');

        if ($company) {
            $models->joinWith("products")->andWhere(['product.company_id' => $company->id]);
        }

        return $this->render('index', [
            // 'categories' => $categories,
            'models' => $models->all(),
            'company' => $company
        ]);
    }
}
