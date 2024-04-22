<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tender_commission".
 *
 * @property int $id
 * @property int $commission_id
 * @property string $role
 * @property int $tender_id
 *
 * @property Comission $commission
 * @property Tender $tender
 */
class TenderCommission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tender_commission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['commission_id', 'role', 'tender_id'], 'required'],
            [['commission_id', 'tender_id'], 'integer'],
            [['role'], 'string', 'max' => 255],
            [['commission_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comission::className(), 'targetAttribute' => ['commission_id' => 'id']],
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
            'commission_id' => Yii::t('main', 'Commission ID'),
            'role' => Yii::t('main', 'Role'),
            'tender_id' => Yii::t('main', 'Tender ID'),
        ];
    }

    /**
     * Gets query for [[Commission]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCommission()
    {
        return $this->hasOne(Comission::className(), ['id' => 'commission_id']);
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
