<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tender".
 *
 * @property int $id
 * @property int $company_id
 * @property int $placement_type Жойлаштириш тури
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string $subject_name Харид қилиш предмети номи
 * @property int $preference_local_manufacturer Махаллий ишлаб чиқарувчига нисбатан 15% миқдорда приференция қўлланилади. 0-1 yoq-ha
 * @property string $formal_language
 * @property int $procedure_bids Иштрокчиларнинг таклифларини кўриб чиқиш тартиби 1-В электронном виде 2-(... jismoniymi shunday)
 * @property int $placement_period Жойлаштириш муддати
 * @property int $purchase_currency UZS, USD, EUR, RUB, GRB, JPY
 * @property string|null $source_of_funding Молиялаштириш манбаи
 * @property string $additional_info Қўшимча маълумотлар
 * @property int $procedure_for_ensuring_participation Иштирок этишни таъминлаш тартиби
 * @property int $amount_deposit Закалат миқдори 3%
 * @property int $payment_order Тўлов тартиби
 * @property int $prepayment Олдиндан тўлов
 * @property int $prepayment_period Олдиндан тўлов киритиш муддати
 * @property int $payment_term_full Тўлов муддати (тўлиқ тўлов)
 * @property int $delivery_time Етказиб бериш муддати (кўп эмас)
 * @property string $contract_proforma Шартнома проформаси:
 * @property int $procurement_plan_id Харидлар режа жадвали
 * @property int $category_product_service Товарлар, ишлар категорияси
 * @property int $region_id
 * @property int $district_id
 * @property string $address
 * @property string $phone
 * @property int $criteria_evaluation_proposals Таклифларни баҳолаш мезони
 * @property int|null $quantitative_tech_part Техник қисмнинг миқдорий кўрсаткичи
 * @property int|null $quantitative_tech_method Нарх усулининг миқдорий кўрсаткичи
 * @property int $min_transition_point Мин. ўтиш балл:
 * @property string $tech_assignment Техник топшириқ:
 * @property string $tech_documentation Тех документация
 * @property string $file_name Файл номи
 * @property int $status
 * @property int $moderator_id
 *
 * @property Company $company
 * @property Region $region
 * @property Region $district
 * @property User $moderator
 * @property TenderCommission[] $tenderCommissions
 * @property TenderIndividualsForCommunication[] $tenderIndividualsForCommunications
 * @property TenderPaymentScheduleAmount[] $tenderPaymentScheduleAmounts
 * @property TenderRequirements[] $tenderRequirements
 */
class Tender extends \yii\db\ActiveRecord
{

    
    const PLACEMENT_TYPE_OFFER = 1;
    const PLACEMENT_TYPE_TENDER = 2;

    public static function getPlacementTypes($index = null){
        $arr = [
            self::PLACEMENT_TYPE_OFFER => t('Отбор наилучших предложений'),
            self::PLACEMENT_TYPE_TENDER => t('Тендер'),
        ];
        return $index === null ? $arr : $arr[$index];
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tender';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'placement_type', 'subject_name', 'preference_local_manufacturer', 'formal_language', 'procedure_bids', 'placement_period', 'purchase_currency', 'additional_info', 'procedure_for_ensuring_participation', 'amount_deposit', 'payment_order', 'prepayment', 'prepayment_period', 'payment_term_full', 'delivery_time', 'contract_proforma', 'procurement_plan_id', 'category_product_service', 'region_id', 'district_id', 'address', 'phone', 'criteria_evaluation_proposals', 'min_transition_point', 'tech_assignment', 'tech_documentation', 'file_name', 'status', 'moderator_id'], 'required'],
            [['company_id', 'placement_type', 'preference_local_manufacturer', 'procedure_bids', 'placement_period', 'purchase_currency', 'procedure_for_ensuring_participation', 'amount_deposit', 'payment_order', 'prepayment', 'prepayment_period', 'payment_term_full', 'delivery_time', 'procurement_plan_id', 'category_product_service', 'region_id', 'district_id', 'criteria_evaluation_proposals', 'quantitative_tech_part', 'quantitative_tech_method', 'min_transition_point', 'status', 'moderator_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['source_of_funding', 'additional_info'], 'string'],
            [['subject_name', 'formal_language', 'contract_proforma', 'address', 'tech_assignment', 'tech_documentation', 'file_name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 25],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['moderator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['moderator_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'company_id' => Yii::t('main', 'Company ID'),
            'placement_type' => Yii::t('main', 'Тип размещения'),
            'created_at' => Yii::t('main', 'Created At'),
            'updated_at' => Yii::t('main', 'Updated At'),
            'subject_name' => Yii::t('main', 'Наименование предмета закупки'),
            'preference_local_manufacturer' => Yii::t('main', 'Применения преференции для местного производителя в размере 15 % '),
            'formal_language' => Yii::t('main', 'Язык оформления'),
            'procedure_bids' => Yii::t('main', 'Порядок рассмотрения предложений участников'),
            'placement_period' => Yii::t('main', 'Placement Period'),
            'purchase_currency' => Yii::t('main', 'Purchase Currency'),
            'source_of_funding' => Yii::t('main', 'Source Of Funding'),
            'additional_info' => Yii::t('main', 'Additional Info'),
            'procedure_for_ensuring_participation' => Yii::t('main', 'Procedure For Ensuring Participation'),
            'amount_deposit' => Yii::t('main', 'Amount Deposit'),
            'payment_order' => Yii::t('main', 'Payment Order'),
            'prepayment' => Yii::t('main', 'Prepayment'),
            'prepayment_period' => Yii::t('main', 'Prepayment Period'),
            'payment_term_full' => Yii::t('main', 'Payment Term Full'),
            'delivery_time' => Yii::t('main', 'Delivery Time'),
            'contract_proforma' => Yii::t('main', 'Contract Proforma'),
            'procurement_plan_id' => Yii::t('main', 'Procurement Plan ID'),
            'category_product_service' => Yii::t('main', 'Category Product Service'),
            'region_id' => Yii::t('main', 'Region ID'),
            'district_id' => Yii::t('main', 'District ID'),
            'address' => Yii::t('main', 'Address'),
            'phone' => Yii::t('main', 'Phone'),
            'criteria_evaluation_proposals' => Yii::t('main', 'Criteria Evaluation Proposals'),
            'quantitative_tech_part' => Yii::t('main', 'Quantitative Tech Part'),
            'quantitative_tech_method' => Yii::t('main', 'Quantitative Tech Method'),
            'min_transition_point' => Yii::t('main', 'Min Transition Point'),
            'tech_assignment' => Yii::t('main', 'Tech Assignment'),
            'tech_documentation' => Yii::t('main', 'Tech Documentation'),
            'file_name' => Yii::t('main', 'File Name'),
            'status' => Yii::t('main', 'Status'),
            'moderator_id' => Yii::t('main', 'Moderator ID'),
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
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * Gets query for [[District]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(Region::className(), ['id' => 'district_id']);
    }

    /**
     * Gets query for [[Moderator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModerator()
    {
        return $this->hasOne(User::className(), ['id' => 'moderator_id']);
    }

    /**
     * Gets query for [[TenderCommissions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTenderCommissions()
    {
        return $this->hasMany(TenderCommission::className(), ['tender_id' => 'id']);
    }

    /**
     * Gets query for [[TenderIndividualsForCommunications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTenderIndividualsForCommunications()
    {
        return $this->hasMany(TenderIndividualsForCommunication::className(), ['tender_id' => 'id']);
    }

    /**
     * Gets query for [[TenderPaymentScheduleAmounts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTenderPaymentScheduleAmounts()
    {
        return $this->hasMany(TenderPaymentScheduleAmount::className(), ['tender_id' => 'id']);
    }

    /**
     * Gets query for [[TenderRequirements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTenderRequirements()
    {
        return $this->hasMany(TenderRequirements::className(), ['tender_id' => 'id']);
    }
}
