<?php

namespace frontend\modules\user\controllers;

use common\models\Product;
use common\models\User;
use frontend\controllers\FrontendController;
use Yii;

class FavoriteController extends FrontendController
{
    public function actionIndex($tab = "products")
    {
        $user = User::findOne(Yii::$app->user->id);

        $products = Product::find()->joinWith('favorites')->where(['favorite.user_id' => $user->id, 'product.status' => Product::STATUS_ACTIVE])->groupBy('product.id')->all();
        $companies = User::find()->joinWith('favorites')->where(['favorite.user_id' => $user->id, 'user.status' => User::STATUS_ACTIVE])->groupBy('user.id')->all();

        return $this->render('index', [
            'user' => $user,
            'products' => $products,
//            'tab' => Product::STATUS_ACTIVE,
            'users' => $companies,
            'tab' => $tab
        ]);
    }
}
