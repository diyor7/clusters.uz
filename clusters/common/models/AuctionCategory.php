<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "auction_category".
 *
 * @property int $id
 * @property int $auction_id
 * @property int $category_id
 * @property int $quantity
 * @property int $unit_id
 * @property float $price
 * @property float $total_sum
 * @property string $description
 *
 * @property Auction $auction
 * @property Category $category
 * @property Unit $unit
 */
class AuctionCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auction_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'quantity', 'unit_id', 'price', 'total_sum', 'description'], 'required'],
            [['auction_id', 'category_id', 'quantity', 'unit_id'], 'integer'],
            [['price', 'total_sum'], 'number', 'min' => 0],
            [['description'], 'string'],
            [['auction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auction::className(), 'targetAttribute' => ['auction_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['unit_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auction_id' => 'Auction ID',
            'category_id' => 'Category ID',
            'quantity' => 'Quantity',
            'unit_id' => 'Unit ID',
            'price' => 'Price',
            'total_sum' => 'Total Sum',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Auction]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuction()
    {
        return $this->hasOne(Auction::className(), ['id' => 'auction_id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Unit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }
}
