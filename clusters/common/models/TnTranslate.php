<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tn_translate".
 *
 * @property int $id
 * @property int $tn_id
 * @property string $name
 * @property string|null $unit
 * @property string|null $unit_short
 * @property int $lang
 *
 * @property Tn $tn
 */
class TnTranslate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tn_translate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tn_id', 'title', 'lang'], 'required'],
            [['tn_id', 'lang'], 'integer'],
            [['title', 'unit', 'unit_short'], 'string', 'max' => 255],
            [['tn_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tn::className(), 'targetAttribute' => ['tn_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tn_id' => 'Tn ID',
            'title' => 'Title',
            'unit' => 'Unit',
            'unit_short' => 'Unit Short',
            'lang' => 'Lang',
        ];
    }

    /**
     * Gets query for [[Tn]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTn()
    {
        return $this->hasOne(Tn::className(), ['id' => 'tn_id']);
    }
}
