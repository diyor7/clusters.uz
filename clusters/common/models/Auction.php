<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "auction".
 *
 * @property int $id
 * @property int $company_id
 * @property int $category_id
 * @property int $status
 * @property float $total_sum
 * @property string|null $created_at
 * @property string|null $cancel_reason
 * @property string|null $auction_end
 * @property string|null $cancel_date
 * @property int|null $payment_status
 * @property string|null $payment_date
 * @property int|null $delivery_period
 * @property int|null $payment_period
 * @property string|null $receiver_email
 * @property string|null $receiver_phone
 * @property int|null $region_id
 * @property string|null $zip_code
 * @property string|null $address
 *
 * @property Company $company
 * @property AuctionRequest $currentRequest
 * @property AuctionCondition[] $auctionConditions
 * @property AuctionFile[] $auctionFiles
 * @property AuctionRequest[] $auctionRequests
 * @property AuctionCaegory[] $auctionCategories
 */
class Auction extends \yii\db\ActiveRecord
{
    const STATUS_MODERATING = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_FINISHED = 3;
    const STATUS_REJECTED = 4;

    public static function getStatuses(){
        return [
            self::STATUS_ACTIVE => t("Активный"),
            self::STATUS_FINISHED => t("Завершен"),
            self::STATUS_MODERATING => t("Модерируется"),
            self::STATUS_REJECTED => t("Отклонен"),
        ];
    }

    public function getStatusName (){
        return array_key_exists($this->status, self::getStatuses()) ? self::getStatuses()[$this->status] : "(Не известно)";
    }

    public $condition_ids = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'status', 'total_sum', 'category_id'], 'required'],
            [['company_id', 'status', 'payment_status', 'delivery_period', 'payment_period', 'region_id', 'category_id', 'views'], 'integer'],
            [['delivery_period', 'payment_period', 'region_id'], 'required'],
            [['total_sum'], 'number'],
            [['created_at', 'auction_end', 'cancel_date', 'payment_date'], 'safe'],
            [['cancel_reason'], 'string'],
            ['receiver_email', 'email'],
            [['receiver_phone'], 'match', 'pattern' => '/^\+998[0-9]{9}$/', 'message' => getTranslate('Неверный формат номера телефона')],
            [['receiver_email', 'receiver_phone', 'zip_code', 'address'], 'string', 'max' => 255],
            [['receiver_email', 'receiver_phone', 'zip_code', 'address'], 'required'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            ['condition_ids', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => t("Номер лота"),
            'company_id' => t("Компания"),
            'category_id' => t("Категория"),
            'status' => t("Статус"),
            'statusName' => t("Статус"),
            'total_sum' => t("Сумма"),
            'created_at' => t('Дата добавления'),
            'updated_at' => t('Дата редактирования'),
            'cancel_reason' => t("Причина (не прошел модерацию)"),
            'auction_end' => t('Дата окончания'),
            'cancel_date' => t("Дата редактирования"),
            'payment_status' => 'Payment Status',
            'payment_date' => 'Payment Date',
            'delivery_period' => t('Срок поставки'),
            'payment_period' => t("Срок оплаты"),
            'receiver_email' => t("Почта получателя"),
            'receiver_phone' => t('Телефон получателя'),
            'region_id' => t('Регион'),
            'zip_code' => t('Zip Code'),
            'views' => t('Просмотры'),
            'address' => t('Адрес'),
            'current_price' => t("Текущая сумма"),
            'auction_request' => t("Кол-во запросов"),
            'auctionRequests' => t("Кол-во запросов")
        ];
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
     * Gets query for [[AuctionConditions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuctionConditions()
    {
        return $this->hasMany(AuctionCondition::className(), ['auction_id' => 'id']);
    }

    /**
     * Gets query for [[AuctionFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuctionFiles()
    {
        return $this->hasMany(AuctionFile::className(), ['auction_id' => 'id']);
    }

    /**
     * Gets query for [[AuctionRequests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuctionRequests()
    {
        return $this->hasMany(AuctionRequest::className(), ['auction_id' => 'id']);
    }

    /**
     * Gets query for [[AuctionRequests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMyRequest()
    {
        return $this->hasOne(AuctionRequest::className(), ['auction_id' => 'id'])->andWhere(['company_id' => Yii::$app->user->identity->company_id]);
    }

    /**
     * Gets query for [[AuctionRequests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * Gets query for [[AuctionTns]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuctionCategories()
    {
        return $this->hasMany(AuctionCategory::className(), ['auction_id' => 'id']);
    }

    public function getCurrentPrice()
    {
        $last_request = AuctionRequest::find()->where(['auction_id' => $this->id])->orderBy("price asc")->one();

        return $last_request ? $last_request->price : $this->total_sum;
    }

    public function getCurrentRequest()
    {
        $last_request = AuctionRequest::find()->where(['auction_id' => $this->id])->orderBy("price asc")->one();

        return $last_request;
    }

    public function getNextPrice (){
        return $this->currentPrice - $this->total_sum * 0.02;
    }

    public function beforeSave($insert)
    {
        if (!$this->created_at)
            $this->created_at = date("Y-m-d H:i:s");

        return parent::beforeSave($insert);
    }
}
