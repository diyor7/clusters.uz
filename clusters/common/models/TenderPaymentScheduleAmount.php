<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tender_payment_schedule_amount".
 *
 * @property int $id
 * @property int $tender_id
 * @property int $fiscal_year
 * @property int $month
 * @property string $account_number
 * @property float $amount
 * @property int $expenses_item
 *
 * @property Tender $tender
 */
class TenderPaymentScheduleAmount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tender_payment_schedule_amount';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tender_id', 'fiscal_year', 'month', 'account_number', 'amount', 'expenses_item'], 'required'],
            [['tender_id', 'fiscal_year', 'month', 'expenses_item'], 'integer'],
            [['amount'], 'number'],
            [['account_number'], 'string', 'max' => 255],
            [['tender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tender::className(), 'targetAttribute' => ['tender_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'tender_id' => Yii::t('main', 'Tender ID'),
            'fiscal_year' => Yii::t('main', 'Fiscal Year'),
            'month' => Yii::t('main', 'Month'),
            'account_number' => Yii::t('main', 'Account Number'),
            'amount' => Yii::t('main', 'Amount'),
            'expenses_item' => Yii::t('main', 'Expenses Item'),
        ];
    }

    /**
     * Gets query for [[Tender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTender()
    {
        return $this->hasOne(Tender::className(), ['id' => 'tender_id']);
    }
}
