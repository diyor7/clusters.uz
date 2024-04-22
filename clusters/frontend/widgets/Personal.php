<?php

namespace frontend\widgets;

use yii\base\Widget;
use common\models\Product;


class Personal extends Widget {
    public $product;

    public function run (){
        if ($this->product){
            $products = Product::find()->where(['status' => true, 'menu_id' => $this->product->menu_id])->andWhere(['!=', 'product_id', $this->product->product_id])->limit(4)->all();

            return $this->render ('personal/index', [
                'products' => $products
            ]);
        }
    }
}