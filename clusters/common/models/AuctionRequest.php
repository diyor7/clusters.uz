<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "auction_request".
 *
 * @property int $id
 * @property int $auction_id
 * @property float $price
 * @property int $company_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $is_winner
 *
 * @property Auction $auction
 * @property Company $company
 */
class AuctionRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auction_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['auction_id', 'price', 'company_id'], 'required'],
            [['auction_id', 'company_id', 'is_winner'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['auction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auction::className(), 'targetAttribute' => ['auction_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
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
            'price' => 'Price',
            'company_id' => 'Company ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_winner' => 'Is Winner',
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
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    public function beforeSave($insert)
    {
        if (!$this->created_at) {
            $this->created_at = date("Y-m-d H:i:s");
        }

        if (!$this->isNewRecord) {
            $this->updated_at = date("Y-m-d H:i:s");
        }
        
        return parent::beforeSave($insert);
    }
}
