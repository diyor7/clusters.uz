<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tender_individuals_for_communication".
 *
 * @property int $id
 * @property string $position
 * @property string $fullname
 * @property int $tender_id
 *
 * @property Tender $tender
 */
class TenderIndividualsForCommunication extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tender_individuals_for_communication';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position', 'fullname', 'tender_id'], 'required'],
            [['position', 'fullname'], 'string'],
            [['tender_id'], 'integer'],
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
            'position' => Yii::t('main', 'Position'),
            'fullname' => Yii::t('main', 'Fullname'),
            'tender_id' => Yii::t('main', 'Tender ID'),
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
