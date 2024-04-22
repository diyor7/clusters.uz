<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "property_translate".
 *
 * @property integer $id
 * @property integer $property_id
 * @property integer $lang
 * @property string $title
 * @property string $count_unit
 * 
 *
 * @property Lang $lang0
 * @property Property $property
 */
class PropertyTranslate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'property_translate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id', 'lang', 'title'], 'required'],
            [['property_id', 'lang'], 'integer'],
            [['count_unit'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 255],
            [['lang'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::className(), 'targetAttribute' => ['lang' => 'id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::className(), 'targetAttribute' => ['property_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_id' => 'Property ID',
            'lang' => 'Lang',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'lang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }
}
