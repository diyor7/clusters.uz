<?php

namespace frontend\widgets;

class Product extends \yii\bootstrap\Widget
{
    public $product;
    public $isFavorite = false;
    public $className = "";

    public function run()
    {
        return $this->render('product/index', [
            'product' => $this->product,
            'isFavorite' => $this->isFavorite,
            'className' => $this->className
        ]);
    }
}
