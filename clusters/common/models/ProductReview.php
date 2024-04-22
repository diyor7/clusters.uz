<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_review".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $user_id
 * @property integer $stars
 * @property integer $text
 * @property string $advantages
 * @property string $disadvantages
 * @property string $created_at
 *
 * @property Product $product
 * @property User $user
 */
class ProductReview extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_review';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'user_id', 'stars', 'text', 'created_at'], 'required'],
            [['product_id', 'user_id', 'stars', 'text'], 'integer'],
            [['advantages', 'disadvantages'], 'string'],
            [['created_at'], 'safe'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'user_id' => 'User ID',
            'stars' => 'Stars',
            'text' => 'Text',
            'advantages' => 'Advantages',
            'disadvantages' => 'Disadvantages',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
