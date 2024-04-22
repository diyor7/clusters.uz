<?php

namespace frontend\modules\store\controllers;

use common\models\Category;
use common\models\Order;
use common\models\Product;
use frontend\controllers\FrontendController;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class ProductController extends FrontendController
{
    public function actionIndex($url, $id, $layout = 'grid', $name = null, $summa_from = null, $summa_to = null, $category_id = null)
    {
        $category = Category::findOne(['id' => $id, 'status' => Category::STATUS_ACTIVE]);

        $parent = $category->parent_id ? $category->parent : $category;

        if (!$category) {
            throw new NotFoundHttpException(t("Страница не найдена"));
        }

        $children = $parent->getCategories()->select(['category.*, (select count(*) from product where product.category_id = category.id or product.category_id in (select id from category c where c.parent_id = category.id)) as product_count'])->andWhere(['status' => Category::STATUS_ACTIVE])->all();

        $category_ids = [$id];

        if ($category->id == $parent->id && count($children) > 0) {
            $category_ids = array_merge($category_ids, ArrayHelper::getColumn($children, 'id'));
        }

        $products = Product::find()->joinWith("productTranslates")->where(['category_id' => $category_ids, 'status' => Product::STATUS_ACTIVE])->orderBy('id desc');

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
        if($id){
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
            'category' => $category,
            'children' => $children,
            'products' => $products->all(),
            'parent' => $parent,
            'layout' => $layout,
            'pages' => $pages,
            'is_open' => $is_open,
            'name' => $name,
            'summa_from' => $summa_from,
            'summa_to' => $summa_to,
            'category_id' => $category_id,
            'count' => $count
        ]);
    }

    public function actionView($url, $id, $delivery_tab = null)
    {
        $product = Product::findOne(['id' => $id]);

        if (!$product || $product->status != Product::STATUS_ACTIVE && $product->company_id != Yii::$app->user->identity->company_id) {
            throw new NotFoundHttpException(t("Страница не найдена"));
        }

        $users_buyed = Order::find()->joinWith("orderLists")->where(['order_list.product_id' => $product->id, 'order.status' => Order::STATUS_FINISHED])->groupBy('order.user_id')->count();

        $related = Product::find()->joinWith("productTranslates")
        ->where(['category_id' => $product->category_id, 'status' => Product::STATUS_ACTIVE])
        ->andWhere(['!=', 'product.id', $id])
        ->orderBy('id desc')->limit(6)->all();

        return $this->render("view", [
            'product' => $product,
            'users_buyed' => $users_buyed,
            'delivery_tab' => $delivery_tab,
            'related' => $related
        ]);
    }
}
