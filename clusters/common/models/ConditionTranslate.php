<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "condition_translate".
 *
 * @property int $id
 * @property int $condition_id
 * @property string $title
 * @property int $lang
 *
 * @property Condition $condition
 */
class ConditionTranslate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'condition_translate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['condition_id', 'title', 'lang'], 'required'],
            [['condition_id', 'lang'], 'integer'],
            [['title'], 'string'],
            [['condition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Condition::className(), 'targetAttribute' => ['condition_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'condition_id' => 'Condition ID',
            'title' => 'Title',
            'lang' => 'Lang',
        ];
    }

    /**
     * Gets query for [[Condition]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCondition()
    {
        return $this->hasOne(Condition::className(), ['id' => 'condition_id']);
    }
}
