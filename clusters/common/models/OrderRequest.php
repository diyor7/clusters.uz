<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_request".
 *
 * @property integer $id
 * @property integer $order_id
 * @property string $price
 * @property integer $company_id
 * @property integer $is_winner
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Company $company
 * @property Order $order
 */
class OrderRequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'price', 'company_id'], 'required'],
            [['order_id', 'company_id', 'is_winner'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'price' => 'Price',
            'company_id' => 'Company ID',
            'is_winner' => 'Is Winner',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
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
