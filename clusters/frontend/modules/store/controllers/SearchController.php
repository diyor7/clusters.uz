<?php

namespace frontend\modules\store\controllers;

use common\models\Product;
use frontend\controllers\FrontendController;
use yii\data\Pagination;

class SearchController extends FrontendController
{
    public function actionIndex($query, $layout = 'grid')
    {
        $products = Product::find()->joinWith("productTranslates")
        ->where(['status' => Product::STATUS_ACTIVE])->orderBy('id desc');

        $products->andWhere([
            'or',
            ['like', 'product_translate.title', $query],
            ['like', 'product_translate.description', $query],
        ]);

        $pages = new Pagination([
            'totalCount' => $products->count(),
            'defaultPageSize' => 36
        ]);

        $products->offset($pages->offset)->limit($pages->limit);

        return $this->render('index', [
            'products' => $products->all(),
            'layout' => $layout,
            'pages' => $pages,
            'query' => $query
        ]);
    }
}
