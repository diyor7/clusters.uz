<?php

namespace frontend\models;

use yii\base\Model;

class RequestPriceForm extends Model {

    public $price;

    public function rules()
    {
        return [
            [['price'], 'required'],
            [['price'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'price' => t("Цена")
        ];
    }
}