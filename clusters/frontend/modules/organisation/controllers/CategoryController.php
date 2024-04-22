<?php

namespace frontend\modules\store\controllers;

use common\models\Category;
use common\models\Order;
use common\models\Product;
use frontend\controllers\FrontendController;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class CategoryController extends FrontendController
{
    public function actionIndex()
    {
        $categories = Category::getProductsWithCount();

        return $this->render('index', [
            'categories' => $categories
        ]);
    }
}
