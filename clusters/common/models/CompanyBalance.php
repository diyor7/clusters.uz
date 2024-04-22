<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_balance".
 *
 * @property integer $id
 * @property integer $company_id
 * @property double $balance
 * @property double $available
 * @property double $blocked
 * @property double $penalty_in
 * @property double $penalty_out
 * @property double $outplay
 * @property double $outgoing
 * @property string $sign
 * @property string $updated_at
 *
 * @property Company $company
 */
class CompanyBalance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_balance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id'], 'required'],
            [['company_id', 'show_balance'], 'integer'],
            [['balance', 'available', 'blocked', 'penalty_in', 'penalty_out', 'outplay', 'outgoing'], 'number', 'min' => 0],
            [['updated_at'], 'safe'],
            [['sign'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
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
            'balance' => 'Balance',
            'available' => 'Available',
            'blocked' => 'Blocked',
            'penalty_in' => 'Penalty In',
            'penalty_out' => 'Penalty Out',
            'outplay' => 'Outplay',
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

    public function calculateBalance()
    {
        $income = CompanyTransaction::find()
            ->where([
                'company_id' => $this->company_id,
                'type' => [
                    CompanyTransaction::TYPE_PAYED_FROM_CONTRACT,
                    CompanyTransaction::TYPE_REFILL,
                    // CompanyTransaction::TYPE_REVERT_BLOCK_COMMISION,
                    // CompanyTransaction::TYPE_REVERT_ZALOG,
                ],
                'status' => CompanyTransaction::STATUS_SUCCESS
            ])->sum("currency") + 0;

        $income_from_penalty =  CompanyTransaction::find()
            ->where([
                'company_id' => $this->company_id,
                'type' => [
                    CompanyTransaction::TYPE_PENALTY_IN
                ],
                'status' => CompanyTransaction::STATUS_SUCCESS
            ])->sum("currency") + 0;

        $outplay = CompanyTransaction::find() // расходы
            ->where([
                'company_id' => $this->company_id,
                'type' => [
                    CompanyTransaction::TYPE_PAY_TO_CONTRACT,
                    CompanyTransaction::TYPE_REVERT_TO_CUSTOMER,
                    CompanyTransaction::TYPE_WITHDRAW,
                    CompanyTransaction::TYPE_COMMISSION,
                ],
                'status' => CompanyTransaction::STATUS_SUCCESS
            ])->sum("currency") + 0;

        $only_comission = CompanyTransaction::find() // расходы
            ->where([
                'company_id' => $this->company_id,
                'type' => [
                    CompanyTransaction::TYPE_COMMISSION,
                ],
                'status' => CompanyTransaction::STATUS_SUCCESS
            ])->sum("currency") + 0;

        $outgoing = CompanyTransaction::find() // издержки
            ->where([
                'company_id' => $this->company_id,
                'type' => [
                    CompanyTransaction::TYPE_PAY_TO_CONTRACT,
                    CompanyTransaction::TYPE_PENALTY_OUT,
                    CompanyTransaction::TYPE_REVERT_TO_CUSTOMER,
                    CompanyTransaction::TYPE_WITHDRAW,
                    CompanyTransaction::TYPE_ZALOG,
                    CompanyTransaction::TYPE_BLOCK_COMMISION,
                    CompanyTransaction::TYPE_RKP,
                ],
                'status' => [
                    CompanyTransaction::STATUS_WAITING,
                    CompanyTransaction::STATUS_MODERATION_REQUIRED,
                    CompanyTransaction::STATUS_ERROR,
                ]
            ])->sum("currency") + 0;

        $outplay_for_penalty = CompanyTransaction::find()
            ->where([
                'company_id' => $this->company_id,
                'type' => [
                    CompanyTransaction::TYPE_PENALTY_OUT
                ],
                'status' => CompanyTransaction::STATUS_SUCCESS
            ])->sum("currency") + 0;

        $deposit = CompanyTransaction::find()
            ->where([
                'company_id' => $this->company_id,
                'type' => [CompanyTransaction::TYPE_ZALOG, CompanyTransaction::TYPE_BLOCK_COMMISION, CompanyTransaction::TYPE_RKP],
                'status' => CompanyTransaction::STATUS_SUCCESS
            ])->sum("currency") + 0;

        $revert_deposit = CompanyTransaction::find()
            ->where([
                'company_id' => $this->company_id,
                'type' => [CompanyTransaction::TYPE_REVERT_ZALOG, CompanyTransaction::TYPE_REVERT_BLOCK_COMMISION, CompanyTransaction::TYPE_BACK_RKP],
                'status' => CompanyTransaction::STATUS_SUCCESS
            ])->sum("currency") + 0;

        $balance = $income + $income_from_penalty - $outplay - $outplay_for_penalty - $outgoing;

        $available = $balance - $deposit + $revert_deposit;

        $this->balance = $balance;
        $this->available = $available;
        $this->blocked = $deposit - $revert_deposit;
        $this->outplay = $only_comission;
        $this->outgoing = $outgoing;
        $this->penalty_in = $income_from_penalty;
        $this->penalty_out = $outplay_for_penalty;

        $this->save();
    }

    public function doSign()
    {
        $this->sign = md5($this->balance . $this->available . $this->blocked . $this->outplay . $this->outgoing . $this->penalty_in . $this->penalty_out . "milliy-art-secret-key-@%*^$#ghGG121!");
    }

    public function checkSign()
    {
        return $this->sign === md5($this->balance . $this->available . $this->blocked . $this->outplay . $this->outgoing . $this->penalty_in . $this->penalty_out . "milliy-art-secret-key-@%*^$#ghGG121!");
    }

    public function beforeSave($insert)
    {
        $this->updated_at = date("Y-m-d H:i:s");
        $this->doSign();

        return parent::beforeSave($insert);
    }
}
