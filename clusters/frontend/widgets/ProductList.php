<?php
namespace frontend\widgets;

class ProductList extends \yii\bootstrap\Widget
{
    public $product;
    public $isFavorite = false;

    public function init(){}

    public function run()
    {
        return $this->render('product-list/index', [
            'product' => $this->product,
            'isFavorite' => $this->isFavorite
        ]);
    }
}