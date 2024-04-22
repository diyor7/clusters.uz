<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "property_value_translate".
 *
 * @property integer $id
 * @property integer $property_value_id
 * @property integer $lang
 * @property string $value
 *
 * @property PropertyValue $propertyValue
 */
class PropertyValueTranslate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'property_value_translate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_value_id', 'lang', 'value'], 'required'],
            [['property_value_id', 'lang'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['property_value_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyValue::className(), 'targetAttribute' => ['property_value_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_value_id' => 'Property Value ID',
            'lang' => 'Lang',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyValue()
    {
        return $this->hasOne(PropertyValue::className(), ['id' => 'property_value_id']);
    }
}
