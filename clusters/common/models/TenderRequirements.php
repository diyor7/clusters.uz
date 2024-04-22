<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tender_requirements".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $content_type Текстовое, Числовое, Бинарное значение
 * @property int $value_type Числовое ? (ravno, ne bolee, ne menee,...) Бинарное ? ( Бинарное значение -> (1-Утверждения(Да/Нет) 2-Согласования(Согласен/Не согласен) ) )
 * @property string|null $value min-max
 * @property int|null $unit_id
 * @property int $necessity 1-Критик 2-Афзалроқ
 * @property int $evaluation_criteria tizim-expert
 * @property int $file_need
 * @property string|null $file_value
 * @property int|null $file_necessity zarur, afzalroq
 * @property int|null $criteria_evaluation_min Критерия бахолаш min
 * @property int|null $criteria_evaluation_max Критерия бахолаш max
 * @property int $tender_id
 *
 * @property Unit $unit
 * @property Tender $tender
 */
class TenderRequirements extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tender_requirements';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'content_type', 'value_type', 'necessity', 'evaluation_criteria', 'file_need', 'tender_id'], 'required'],
            [['title', 'description'], 'string'],
            [['content_type', 'value_type', 'unit_id', 'necessity', 'evaluation_criteria', 'file_need', 'file_necessity', 'criteria_evaluation_min', 'criteria_evaluation_max', 'tender_id'], 'integer'],
            [['value', 'file_value'], 'string', 'max' => 255],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['unit_id' => 'id']],
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
            'title' => Yii::t('main', 'Title'),
            'description' => Yii::t('main', 'Description'),
            'content_type' => Yii::t('main', 'Content Type'),
            'value_type' => Yii::t('main', 'Value Type'),
            'value' => Yii::t('main', 'Value'),
            'unit_id' => Yii::t('main', 'Unit ID'),
            'necessity' => Yii::t('main', 'Necessity'),
            'evaluation_criteria' => Yii::t('main', 'Evaluation Criteria'),
            'file_need' => Yii::t('main', 'File Need'),
            'file_value' => Yii::t('main', 'File Value'),
            'file_necessity' => Yii::t('main', 'File Necessity'),
            'criteria_evaluation_min' => Yii::t('main', 'Criteria Evaluation Min'),
            'criteria_evaluation_max' => Yii::t('main', 'Criteria Evaluation Max'),
            'tender_id' => Yii::t('main', 'Tender ID'),
        ];
    }

    /**
     * Gets query for [[Unit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
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
