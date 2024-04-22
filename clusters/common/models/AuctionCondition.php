<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "auction_condition".
 *
 * @property int $id
 * @property int $auction_id
 * @property int|null $condition_id
 * @property string|null $own
 * @property string|null $inputs
 * @property string|null $texts
 *
 * @property Auction $auction
 * @property Condition $condition
 */
class AuctionCondition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auction_condition';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['auction_id'], 'required'],
            [['auction_id', 'condition_id'], 'integer'],
            [['own', 'texts', 'inputs'], 'string'],
            [['auction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auction::className(), 'targetAttribute' => ['auction_id' => 'id']],
            [['condition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Condition::className(), 'targetAttribute' => ['condition_id' => 'id']],
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
            'condition_id' => 'Condition ID',
            'own' => 'Own',
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
     * Gets query for [[Condition]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCondition()
    {
        return $this->hasOne(Condition::className(), ['id' => 'condition_id']);
    }
}
