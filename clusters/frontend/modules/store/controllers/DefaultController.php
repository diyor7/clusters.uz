<?php

namespace frontend\modules\store\controllers;

use common\models\Category;
use common\models\Product;
use yii\data\Pagination;
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
    public function actionIndex($name = null, $summa_from = null, $summa_to = null, $category_id = null)
    {
        $products = Product::find()
            ->joinWith('productTranslates')
            ->select(['product.*, (select count(*) from favorite where favorite.product_id = product.id) as fav_count'])
            ->where(['status' => Product::STATUS_ACTIVE])
            ->orderBy("id desc");

        $is_open = false;

        if ($name) {
            $products->andWhere([
                'or',
                ['product.id' => $name],
                ['like', 'product_translate.title', $name]
            ]);
            $is_open = true;
        }

        if ($summa_from) {
            $products->andWhere(['>=', 'product.price', $summa_from]);
            $is_open = true;
        }

        if ($summa_to) {
            $products->andWhere(['<=', 'product.price', $summa_to]);
            $is_open = true;
        }

        if ($category_id) {
            $products->andWhere(['product.category_id' => $category_id]);
            $is_open = true;
        }

        $count = $products->groupBy('product.id')->count();

        $pages = new Pagination([
            'totalCount' => $products->count(),
            'defaultPageSize' => 36,
            'pageSizeLimit' => [1, 36 * 3]
        ]);

        $products->offset($pages->offset)->limit($pages->limit)->groupBy('product.id');

        return $this->render('index', [
            'products' => $products->all(),
            'is_open' => $is_open,
            'name' => $name,
            'summa_from' => $summa_from,
            'summa_to' => $summa_to,
            'category_id' => $category_id,
            'count' => $count,
            'pages' => $pages
        ]);
    }
}
