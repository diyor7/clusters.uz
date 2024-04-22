<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "auction_file".
 *
 * @property int $id
 * @property int $auction_id
 * @property string $filename
 * @property string|null $type
 *
 * @property Auction $auction
 */
class AuctionFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auction_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['auction_id', 'filename'], 'required'],
            [['auction_id'], 'integer'],
            [['filename', 'type'], 'string', 'max' => 255],
            [['auction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auction::className(), 'targetAttribute' => ['auction_id' => 'id']],
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
            'filename' => 'Filename',
            'type' => 'Type',
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
}
