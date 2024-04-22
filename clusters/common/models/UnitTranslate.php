<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "unit_translate".
 *
 * @property int $id
 * @property int $unit_id
 * @property string $title
 * @property int $lang
 *
 * @property Unit $unit
 */
class UnitTranslate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unit_translate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_id', 'title', 'lang'], 'required'],
            [['unit_id', 'lang'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['unit_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_id' => 'Unit ID',
            'title' => 'Title',
            'lang' => 'Lang',
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
}
