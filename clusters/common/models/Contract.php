<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contract".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property integer $producer_id
 * @property integer $order_id
 * @property integer $auction_id
 * @property string $price
 * @property integer $customer_signed
 * @property integer $producer_signed
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $customer_sign_date
 * @property string $producer_sign_date
 * @property string $customer_pay_date
 * @property string $customer_mark_delivered_date
 * @property string $customer_cancel_date
 * @property string $producer_cancel_date
 *
 * @property Order $order
 * @property User $customer
 * @property Company $producer
 */
class Contract extends \yii\db\ActiveRecord
{
    const STATUS_CREATED = 1;
    const STATUS_WAITING_PAYMENT_FROM_CUSTOMER = 2;

    const STATUS_PROCESSING = 3;
    const STATUS_DELIVERED = 4;

    const STATUS_END = 5;

    const STATUS_ARBITRATION = 6;
    const STATUS_CANCELLED = 7;

    public static function getStatuses()
    {
        return [
            self::STATUS_CREATED => t("Оформлен"),
            self::STATUS_WAITING_PAYMENT_FROM_CUSTOMER => t("Ожидание оплаты от заказчика"),
            self::STATUS_PROCESSING => t("Выполняется"),
            self::STATUS_DELIVERED => t("Доставлен"),
            self::STATUS_END => t("Завершен"),
            self::STATUS_ARBITRATION => t("В арбитаже"),
            self::STATUS_CANCELLED => t("Расторгнуть")
        ];
    }

    public function getStatusClass()
    {
        switch ($this->status) {
            case self::STATUS_CREATED:
                return 'item__badge--status-1';
            case self::STATUS_DELIVERED:
                return 'item__badge--status-3';
            case self::STATUS_CANCELLED:
                return 'item__badge--status-2';
            case self::STATUS_WAITING_PAYMENT_FROM_CUSTOMER:
                return 'item__badge--status-1';
            case self::STATUS_PROCESSING:
                return 'item__badge--status-1';
            case self::STATUS_END:
                return 'item__badge--status-3';
            case self::STATUS_ARBITRATION:
                return 'item__badge--status-2';
            default:
                return 'item__badge--status-1';
        }
    }

    public function getStatusName()
    {
        return array_key_exists($this->status, self::getStatuses()) ? self::getStatuses()[$this->status] : null;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contract';
    }
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'producer_id', 'price', 'status'], 'required'],
            [['customer_id', 'producer_id', 'order_id', 'auction_id', 'customer_signed', 'producer_signed', 'status'], 'integer'],
            [['price'], 'number'],
            [[
                'created_at', 'updated_at',
                'customer_sign_date', 'producer_sign_date', 'customer_pay_date', 'customer_mark_delivered_date', 'customer_cancel_date', 'producer_cancel_date'
            ], 'safe'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['auction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auction::className(), 'targetAttribute' => ['auction_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['producer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['producer_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'producer_id' => 'Producer ID',
            'order_id' => 'Order ID',
            'price' => 'Price',
            'customer_signed' => 'Customer Signed',
            'producer_signed' => 'Producer Signed',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuction()
    {
        return $this->hasOne(Auction::className(), ['id' => 'auction_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Company::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducer()
    {
        return $this->hasOne(Company::className(), ['id' => 'producer_id']);
    }

    public function beforeSave($insert)
    {
        if (!$this->created_at) {
            $this->created_at = date("Y-m-d H:i:s");
        }

        if (!$this->isNewRecord) {
            $this->updated_at = date("Y-m-d H:i:s");
        }

        if ($this->isNewRecord) {
            $this->status = self::STATUS_CREATED;
            $this->producer_signed = 0;
            $this->customer_signed = 0;
        }

        if ($this->status == self::STATUS_CREATED && $this->customer_signed == 1 && $this->producer_signed == 1) {
            $this->status = self::STATUS_WAITING_PAYMENT_FROM_CUSTOMER;
        }

        return parent::beforeSave($insert);
    }
}
