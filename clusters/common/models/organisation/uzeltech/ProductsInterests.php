<?php

namespace common\models\organisation\uzeltech;

use Yii;

/**
 * This is the model class for table "products_interests".
 *
 * @property int $id
 * @property int $product_id
 * @property string $user_ip
 * @property string $user_agent
 */
class ProductsInterests extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'uzeltech.products_interests';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'user_ip', 'user_agent'], 'required'],
            [['product_id'], 'integer'],
            [['user_agent'], 'string'],
            [['user_ip'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'product_id' => Yii::t('frontend', 'Product ID'),
            'user_ip' => Yii::t('frontend', 'User Ip'),
            'user_agent' => Yii::t('frontend', 'User Agent'),
        ];
    }
}
