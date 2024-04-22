<?php

namespace common\models;

use Yii;
use yii\bootstrap\Html;

/**
 * This is the model class for table "notification".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $order_id
 * @property string $created_at
 * @property integer $is_read
 * @property integer $type
 *
 * @property Order $order
 * @property User $user
 */
class Notification extends \yii\db\ActiveRecord
{
    const TYPE_DELIVERED = Order::STATUS_FINISHED;
    const TYPE_NEW_ORDER = Order::STATUS_CREATED;
    const TYPE_CANCALLED = Order::STATUS_CANCELLED;

    public function getText()
    {
        $order_link_for_seller = Html::a('№' . $this->order_id, toRoute('/cabinet/order/' . $this->order_id));
        $order_link_for_buyer = Html::a('№' . $this->order_id, toRoute('/user/order/' . $this->order_id));

        switch($this->type){
            case self::TYPE_DELIVERED: return t("Ваш заказ {order} доставлен", [
                'order' => $order_link_for_buyer
            ]);
            case self::TYPE_NEW_ORDER: return t("Вам поступил новый заказ {order}", [
                'order' => $order_link_for_seller
            ]);
            case self::TYPE_CANCALLED: return t("Ваш заказ {order} был отменён", [
                'order' => $order_link_for_buyer
            ]);

            default: return null;
        }
    }

    public function getDate()
    {
        return $this->created_at ? date("d.m.Y H:i", strtotime($this->created_at)) : null;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'type'], 'required'],
            [['user_id', 'order_id', 'is_read', 'type'], 'integer'],
            [['created_at'], 'safe'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
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
            'user_id' => 'User ID',
            'order_id' => 'Order ID',
            'created_at' => 'Created At',
            'is_read' => 'Is Read',
            'type' => 'Type',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
