<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_transaction".
 *
 * @property integer $id
 * @property integer $transaction_id
 * @property integer $company_id
 * @property integer $contract_id
 * @property integer $auction_id
 * @property integer $order_id
 * @property string $currency
 * @property integer $type
 * @property string $description
 * @property integer $status
 * @property integer $user_id
 * @property integer $reverted_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $transaction_date
 *
 * @property Company $company
 * @property Contract $contract
 */
class CompanyTransaction extends \yii\db\ActiveRecord
{
    const TYPE_PAY_TO_CONTRACT = 1; // dogovor bo'yicha to'lov
    const TYPE_PAYED_FROM_CONTRACT = 2; // dogovor bo'yicha qabul
    const TYPE_REVERT_TO_CUSTOMER = 3; // sotuvchiga pul qaytarildi
    const TYPE_REVERT_FROM_PRODUCER = 4; // yetkazib beruvchidan pul qaytib qaytarildi
    // const TYPE_DEPOSIT = 5; // zalog va kommisiya yechib olindi (bu kerak EMAS)
    // const TYPE_REVERT = 6; // zalog ortga qaytarildi (bu kerak EMAS)
    const TYPE_WITHDRAW = 7; // balansdan schetiga yechib olindi
    const TYPE_REFILL = 8; // balansni to'ldirdi
    const TYPE_PENALTY_IN = 9; // shtraf qabul qildi
    const TYPE_PENALTY_OUT = 10; // shtraf to'ladi
    const TYPE_COMMISSION = 11; // komissiya to'ladi
    const TYPE_RKP = 12; // dogovor bo'yicha predoplata yechib olindi
    const TYPE_BACK_RKP = 13; // dogovor bo'yicha predoplata qaytarib berildi
    
    const TYPE_ZALOG = 14; // zalog olindi
    const TYPE_REVERT_ZALOG = 15; // zalog qaytarildi
    const TYPE_BLOCK_COMMISION = 16; // komissiya olindi
    const TYPE_REVERT_BLOCK_COMMISION= 17; // kommisiya qaytarildi

    public static function getTypes(){
        return [
            self::TYPE_PAY_TO_CONTRACT => t("Оплачен по договору"),
            self::TYPE_PAYED_FROM_CONTRACT => t("Получен по договору"),
            self::TYPE_REVERT_TO_CUSTOMER => t("Возвращение заказчику"),
            self::TYPE_REVERT_FROM_PRODUCER => t("Возвращение от поставщика"),
            // self::TYPE_DEPOSIT => t("Депозит"),
            // self::TYPE_REVERT => t("Возврат"),
            self::TYPE_WITHDRAW => t("Снятие"),
            self::TYPE_REFILL => t("Пополнение счёта"),
            self::TYPE_PENALTY_IN => t("Получен от штрафа"),
            self::TYPE_PENALTY_OUT => t("Оплачен за штраф"),
            self::TYPE_COMMISSION => t("Оплата за комиссионного сбора"),
            self::TYPE_RKP => t("Блокировка 100% оплаты"),
            self::TYPE_BACK_RKP => t("Разблокировка 100% оплаты"),
            self::TYPE_ZALOG => t("Блокирована залоговая сумма"),
            self::TYPE_REVERT_ZALOG => t("Разблокировка залоговой суммы"),
            self::TYPE_BLOCK_COMMISION => t("Блокирована комиссионного сбора"),
            self::TYPE_REVERT_BLOCK_COMMISION => t("Разблокировка комиссионного сбора")
        ];
    }

    public function getTypeName(){
        return array_key_exists($this->type, self::getTypes()) ? self::getTypes()[$this->type] : null;
    }

    public function getTypeNamePlusMinus(){
        return in_array($this->type, [self::TYPE_REVERT_BLOCK_COMMISION, self::TYPE_REVERT_ZALOG,  self::TYPE_BACK_RKP, self::TYPE_REFILL]) ? "+ " : "- ";
    }

    const STATUS_SUCCESS = 1;
    const STATUS_WAITING = 2;
    const STATUS_ERROR = 3;
    const STATUS_MODERATION_REQUIRED = 4;
    const STATUS_CANCALLED = 5;

    public static function getStatuses (){
        return [
            self::STATUS_SUCCESS => t("Успешен"),
            self::STATUS_WAITING => t("Ожидание"),
            self::STATUS_ERROR => t("Ошибка"),
            self::STATUS_MODERATION_REQUIRED => t("Требуется модерация"),
            self::STATUS_CANCALLED => t("Отменён"),
        ];
    }

    public $name;
    public $status_bank;
    public $tin;
    public $account;
    public $mfo;
    public $file;

    public function getStatusName(){
        return array_key_exists($this->status, self::getStatuses()) ? self::getStatuses()[$this->status] : null;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'currency', 'type', 'transaction_id', 'transaction_date'], 'required'],
            [['company_id', 'contract_id', 'type', 'status', 'user_id', 'order_id', 'auction_id', 'reverted_id', 'transaction_id'], 'integer'],
//            [['currency'], 'number', 'min' => 0],
            [['transaction_id'], 'unique'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'transaction_date', 'currency'], 'safe'],
            ['file', 'file', 'extensions' => 'xls, xlsx', 'skipOnEmpty' => true,'maxSize' => 1024 * 1024 * 5],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['contract_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contract::className(), 'targetAttribute' => ['contract_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['auction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Auction::className(), 'targetAttribute' => ['auction_id' => 'id']],
            [['reverted_id'], 'exist', 'skipOnError' => true, 'targetClass' => self::className(), 'targetAttribute' => ['reverted_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'contract_id' => 'Contract ID',
            'auction_id' => 'Auction ID',
            'reverted_id' => 'Self ID',
            'currency' => 'Currency',
            'type' => 'Type',
            'description' => 'Description',
            'status' => 'Status',
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
    public function getReverted()
    {
        return $this->hasOne(self::className(), ['id' => 'reverted_id']);
    }

    public function getDate(){
        return date("d.m.Y H:i:s", strtotime($this->created_at));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContract()
    {
        return $this->hasOne(Contract::className(), ['id' => 'contract_id']);
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

    public function beforeSave($insert)
    {
        if (!$this->created_at) $this->created_at = date("Y-m-d H:i:s");

        if (!$this->isNewRecord) $this->updated_at = date("Y-m-d H:i:s");

        $this->user_id = Yii::$app->user->id;

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $company_balance = CompanyBalance::findOne(['company_id' => $this->company_id]);

        if ($company_balance){
            $company_balance->calculateBalance();
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        $company_balance = CompanyBalance::findOne(['company_id' => $this->company_id]);

        if ($company_balance){
            $company_balance->calculateBalance();
        }
        
        return parent::afterDelete();
    }
}
