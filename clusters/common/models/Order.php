<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $company_id
 * @property integer $address_id
 * @property integer $type
 * @property string $address_text
 * @property string $receiver_fio
 * @property string $receiver_phone
 * @property integer $delivery_type
 * @property integer $payment_type
 * @property double $total_sum
 * @property string $created_at
 * @property double $shipping_sum
 * @property integer $status
 * @property integer $payment_status
 * @property string $payment_date
 * @property string $cancel_reason
 * @property string $tender_end
 * @property string $request_end
 *
 * @property User $user
 * @property Company $company
 * @property Address $address
 */
class Order extends \yii\db\ActiveRecord
{
    public $agreement = 1;

    // для обычных заказов
    const STATUS_CREATED = 1;
    const STATUS_WAITING_PAYMENT = 2;
    const STATUS_DELIVERING = 3;
    const STATUS_FINISHED = 4;
    const STATUS_CANCELLED = 5;

    // для тендеров
    const STATUS_WAITING_ACCEPT = 6;
    const STATUS_REQUESTING = 7;
    const STATUS_SELECTED_PRODUCER = 8;
    const STATUS_CANCELLED_FROM_PRODUCER = 9;

    public static function getStatuses()
    {
        return [
            self::STATUS_CREATED => t("Создан"),
            self::STATUS_WAITING_PAYMENT => t("Ожидание оплаты"),
            self::STATUS_DELIVERING => t("Доставляется"),
            self::STATUS_FINISHED => t("Доставлен"),
            self::STATUS_CANCELLED => t("Отменён"),

            self::STATUS_WAITING_ACCEPT => t("Ожидание подтверждения"),
            self::STATUS_REQUESTING => t("Поиск предложений"),
            self::STATUS_SELECTED_PRODUCER => t("Выбран поставщик"),
            self::STATUS_CANCELLED_FROM_PRODUCER => t("Отменён поставщиком"),
        ];
    }

    public static function getGeneralStatuses()
    {
        return [
            self::STATUS_CREATED => t("Создан"),
            self::STATUS_WAITING_PAYMENT => t("Ожидание оплаты"),
            self::STATUS_DELIVERING => t("Доставляется"),
            self::STATUS_FINISHED => t("Доставлен"),
            self::STATUS_CANCELLED => t("Отменён"),
        ];
    }

    public function getStatusName()
    {
        return array_key_exists($this->status, self::getStatuses()) ? self::getStatuses()[$this->status] : null;
    }

    const TYPE_GENERAL = 1; //обычный заказ
    const TYPE_TENDER = 2; // тендер 48 часов

    public static function getTypes()
    {
        return [
            self::TYPE_GENERAL => t("Обычный заказ"),
            self::TYPE_TENDER => t("Запрос цен, тендер"),
        ];
    }

    const DELIVERY_TYPE_FREE_SHIPPING = 1;
    const DELIVERY_TYPE_PICKUP_YOURSELF = 2;
    const DELIVERY_TYPE_EXPRESS = 3;

    public static function getDeliveryTypes()
    {
        return [
            self::DELIVERY_TYPE_FREE_SHIPPING => t("Доставка от производителя"),
            self::DELIVERY_TYPE_PICKUP_YOURSELF => t("Самовывоз"),
            // self::DELIVERY_TYPE_EXPRESS => t("Через почту"),
        ];
    }

    public function getDeliveryType()
    {
        return array_key_exists($this->delivery_type, self::getDeliveryTypes()) ? self::getDeliveryTypes()[$this->delivery_type] : null;
    }

    const PAYMENT_TYPE_CASH = 1;
    const PAYMENT_TYPE_TERMINAL = 2;
    const PAYMENT_TYPE_CLICK = 3;
    const PAYMENT_TYPE_PAYME = 4;
    const PAYMENT_TYPE_TRANSFER = 5;
    const PAYMENT_TYPE_BANK_CARD = 6;
    const PAYMENT_TYPE_BALANCE = 7;

    public static function getPaymentTypes()
    {
        return [
            // self::PAYMENT_TYPE_CASH => t("Наличными"),
            // self::PAYMENT_TYPE_TERMINAL => t("Терминал"),
            // self::PAYMENT_TYPE_CLICK => t("Click"),
            // self::PAYMENT_TYPE_PAYME => t("Payme"),
            // self::PAYMENT_TYPE_TRANSFER => t("Перевод"),
            // self::PAYMENT_TYPE_BANK_CARD => t("Банковские карты"),
            self::PAYMENT_TYPE_BALANCE => t("Баланс в системе"),
        ];
    }

    public function getPaymentType()
    {
        return array_key_exists($this->payment_type, self::getPaymentTypes()) ? self::getPaymentTypes()[$this->payment_type] : null;
    }

    const PAYMENT_STATUS_WAITING = 1;
    const PAYMENT_STATUS_PAYED = 2;
    const PAYMENT_STATUS_CENCELLED = 3;

    public static function getPaymentStatuses()
    {
        return [
            self::PAYMENT_STATUS_WAITING => t("Ожидание"),
            self::PAYMENT_STATUS_PAYED => t("Оплачен"),
            self::PAYMENT_STATUS_CENCELLED => t("Отменён"),
        ];
    }

    public function getStatusClass()
    {
        switch ($this->status) {
            case self::STATUS_CREATED:
                return 'item__badge--status-1';
            case self::STATUS_FINISHED:
                return 'item__badge--status-3';
            case self::STATUS_CANCELLED:
                return 'item__badge--status-2';
            case self::STATUS_WAITING_ACCEPT:
                return 'item__badge--status-1';
            case self::STATUS_REQUESTING:
                return 'item__badge--status-1';
            case self::STATUS_SELECTED_PRODUCER:
                return 'item__badge--status-3';
            case self::STATUS_CANCELLED_FROM_PRODUCER:
                return 'item__badge--status-2';
            default:
                return 'item__badge--status-1';
        }
    }

    public function getPaymentStatus()
    {
        return array_key_exists($this->payment_status, self::getPaymentStatuses()) ? self::getPaymentStatuses()[$this->payment_status] : null;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[/*'user_id',*/'receiver_fio', 'receiver_phone', 'delivery_type', 'payment_type', /*'total_sum', 'created_at', 'shipping_sum', 'status'*/], 'required'],
            [['user_id', 'address_id', 'delivery_type', 'payment_type', 'status', 'payment_status', 'company_id'], 'integer'],
            [['receiver_phone'], 'match', 'pattern' => '/^\+998[0-9]{9}$/', 'message' => getTranslate('Неверный формат номера телефона')],
            [['address_text', 'cancel_reason'], 'string'],
            [['total_sum', 'shipping_sum'], 'number'],
            [['created_at', 'payment_date', 'tender_end', 'request_end', 'cancel_date'], 'safe'],
            [['receiver_fio', 'receiver_phone'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address_id' => 'id']],

            [['agreement'], 'required', 'message' => t("Нужно согласиться с офертой.")],
            ['agreement', function ($attribute, $params, $validator) {
                if (!in_array($this->$attribute, [1, true])) {
                    $this->addError($attribute, t("Нужно согласиться с офертой."));
                }
            }],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => t("№ заявки"),
            'user_id' => t("Пользователь"),
            'company_id' => t("Поставщик"),
            'address_id' => t("Адрес"),
            'address_text' => t('Адрес'),
            'receiver_fio' => t('Ф.И.О. получателя по паспорту'),
            'receiver_phone' => t('Телефон получателя'),
            'delivery_type' => t('Тип доставки'),
            'payment_type' => t("Тип оплаты"),
            'total_sum' => t('Общая сумма'),
            'created_at' => t('Дата создания'),
            'shipping_sum' => t('Сумма доставки'),
            'status' => t('Статус'),
            'payment_status' => t('Статус оплаты'),
            'payment_date' => t('Дата оплаты'),
            'cancel_reason' => t('Причина отмены'),
            'tender_end' => t('Дата окончания тендера'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderLists()
    {
        return $this->hasMany(OrderList::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderRequests()
    {
        return $this->hasMany(OrderRequest::className(), ['order_id' => 'id']);
    }

    public function getMyRequest()
    {
        return OrderRequest::findOne(['order_id' => $this->id, 'company_id' => Yii::$app->user->identity->company_id]);
    }

    public function getActual_price()
    {
        return count($this->orderRequests) > 0 ? $this->getOrderRequests()->min("price") : $this->total_sum;
    }

    public function getWinner()
    {
        return OrderRequest::findOne(['order_id' => $this->id, 'is_winner' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyTransactions()
    {
        return $this->hasMany(CompanyTransaction::className(), ['order_id' => 'id']);
    }

    public static function checkTender()
    {
        $tenders = Order::find()->where([
            'and',
            ['type' => Order::TYPE_TENDER, 'status' => Order::STATUS_REQUESTING],
            ['<', 'tender_end', date("Y-m-d H:i:s")]
        ])->all();

        if (count($tenders) > 0) {
            foreach ($tenders as $order) {

                $customer_id = $order->user->company_id;
                $customer_user_id = $order->user->id;
                $producer_id = $order->company_id;

                $winner_price = $order->getOrderRequests() ? $order->getOrderRequests()->min("price") : 0;

                if ($winner_price > 0) {
                    $winner = OrderRequest::find()->where(['order_id' => $order->id, 'price' => $winner_price])->orderBy('created_at asc')->one();

                    if ($winner) {
                        $winner->is_winner = 1;
                        $winner->save();
                        $producer_id = $winner->company_id;
                    }
                } else {
                    $winner_price = $order->total_sum + $order->shipping_sum;
                }

                $zalogs = CompanyTransaction::find()->where(['order_id' => $order->id, 'type' => CompanyTransaction::TYPE_ZALOG])->andWhere(['not in', 'company_id', [$customer_id, $producer_id]])->all();

                foreach ($zalogs as $transaction) {
                    $revert = new CompanyTransaction([
                        'company_id' => $transaction->company_id,
                        'currency' => $transaction->currency,
                        'order_id' => $transaction->order_id,
                        'type' => CompanyTransaction::TYPE_REVERT_ZALOG,
                        'status' => CompanyTransaction::STATUS_SUCCESS
                    ]);

                    if ($revert->save()){
                        $transaction->reverted_id = $revert->id;
                        $transaction->save(false);
                    }
                }

                $block_kommisions_from_losers = CompanyTransaction::find()->where(['order_id' => $order->id, 'type' => CompanyTransaction::TYPE_BLOCK_COMMISION, 'reverted_id' => null])/*->andWhere(['not in', 'company_id', [$customer_id, $producer_id]])*/->all();

                foreach ($block_kommisions_from_losers as $transaction) {
                    $revert = new CompanyTransaction([
                        'company_id' => $transaction->company_id,
                        'currency' => $transaction->currency,
                        'order_id' => $transaction->order_id,
                        'type' => CompanyTransaction::TYPE_REVERT_BLOCK_COMMISION,
                        'status' => CompanyTransaction::STATUS_SUCCESS
                    ]);

                    if ($revert->save()){
                        $transaction->reverted_id = $revert->id;
                        $transaction->save(false);
                    }
                }

                $commission_percentage = isset(Yii::$app->params['commission_percentage']) ? Yii::$app->params['commission_percentage'] : 0.15;

                $komissiya = $winner_price * $order->getOrderLists()->sum("quantity") * $commission_percentage / 100;

                $commision_from_customer = new CompanyTransaction([
                    'company_id' => $customer_id,
                    'currency' => $komissiya,
                    'order_id' => $transaction->order_id,
                    'type' => CompanyTransaction::TYPE_COMMISSION,
                    'status' => CompanyTransaction::STATUS_SUCCESS
                ]);
                $commision_from_customer->save(false);

                $commision_from_producer = new CompanyTransaction([
                    'company_id' => $producer_id,
                    'currency' => $komissiya,
                    'order_id' => $transaction->order_id,
                    'type' => CompanyTransaction::TYPE_COMMISSION,
                    'status' => CompanyTransaction::STATUS_SUCCESS
                ]);
                $commision_from_producer->save(false);

                $contract = new Contract([
                    'customer_id' => $customer_id,
                    'producer_id' => $producer_id,
                    'order_id' => $order->id,
                    'price' => $winner_price * $order->getOrderLists()->sum("quantity"),
                    'customer_signed' => 1,
                    'producer_signed' => 1,
                    'status' => Contract::STATUS_WAITING_PAYMENT_FROM_CUSTOMER
                ]);

                $contract->save();
            }
        }

        Order::updateAll([
            'status' => Order::STATUS_SELECTED_PRODUCER
        ], [
            'and',
            ['type' => Order::TYPE_TENDER, 'status' => Order::STATUS_REQUESTING],
            ['<', 'tender_end', date("Y-m-d H:i:s")]
        ]);

        $waitings = Order::find()->where([
            'and',
            ['type' => Order::TYPE_TENDER, 'status' => Order::STATUS_WAITING_ACCEPT],
            ['<', 'tender_end', date("Y-m-d H:i:s")]
        ])->all();

        if (count($waitings) > 0) {
            foreach ($waitings as $order) {
                $zalog = CompanyTransaction::find()->where(['order_id' => $order->id, 'type' => CompanyTransaction::TYPE_ZALOG])->andWhere(['company_id' => $order->user->company_id])->one();

                $revert_zalog = new CompanyTransaction([
                    'company_id' => $zalog->company_id,
                    'currency' => $zalog->currency,
                    'order_id' => $zalog->order_id,
                    'type' => CompanyTransaction::TYPE_REVERT_ZALOG
                ]);

                if($revert_zalog->save()){
                    $zalog->reverted_id = $revert_zalog->id;
                    $zalog->save(false);
                }

                $block_komission = CompanyTransaction::find()->where(['order_id' => $order->id, 'type' => CompanyTransaction::TYPE_BLOCK_COMMISION])->andWhere(['company_id' => $order->user->company_id])->one();

                $revert_block_komission = new CompanyTransaction([
                    'company_id' => $block_komission->company_id,
                    'currency' => $block_komission->currency,
                    'order_id' => $block_komission->order_id,
                    'type' => CompanyTransaction::TYPE_REVERT_BLOCK_COMMISION
                ]);

                if($revert_block_komission->save()){
                    $block_komission->reverted_id = $revert_block_komission->id;
                }
            }
        }

        Order::updateAll([
            'status' => Order::STATUS_CANCELLED_FROM_PRODUCER
        ], [
            'and',
            ['type' => Order::TYPE_TENDER, 'status' => Order::STATUS_WAITING_ACCEPT],
            ['<', 'request_end', date("Y-m-d H:i:s")]
        ]);
    }
}
