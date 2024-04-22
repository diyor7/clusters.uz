<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "property_value".
 *
 * @property integer $id
 * @property integer $property_id
 *
 * @property ProductProperty[] $productProperties
 * @property Property $property
 * @property PropertyValueTranslate[] $propertyValueTranslates
 */
class PropertyValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'property_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id'], 'required'],
            [['property_id'], 'integer'],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::className(), 'targetAttribute' => ['property_id' => 'id']],
            ['titles', 'safe'],
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
            'titles' => "Наименование",

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductProperties()
    {
        return $this->hasMany(ProductProperty::className(), ['property_value_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyValueTranslates()
    {
        return $this->hasMany(PropertyValueTranslate::className(), ['property_value_id' => 'id']);
    }

    public function getTitles()
    {
        return ArrayHelper::map($this->propertyValueTranslates, 'lang', 'value');
    }

    public function setTitles($val)
    {
        $this->titles = $val;
    }

    public function getTitlesString()
    {
        return join(' / ', ArrayHelper::getColumn($this->propertyValueTranslates, 'value'));
    }

    public function setValue($val)
    {
        $this->value = $val;
    }

    public function getValue()
    {
        return $this->translate ? $this->translate->value : null;
    }

    public function getTranslate()
    {
        return $this->hasOne(PropertyValueTranslate::className(), ['property_value_id' => 'id'])->andWhere(['lang' => \Yii::$app->languageId]);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (is_array($this->titles)) {
            foreach ($this->titles as $lang => $value) {
                $translate = PropertyValueTranslate::findOne(['property_value_id' => $this->id, 'lang' => $lang]);

                if (!$translate) {
                    $translate = new PropertyValueTranslate([
                        'property_value_id' => $this->id,
                        'lang' => $lang
                    ]);
                }

                $translate->value = $value;

                $translate->save();
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }
}
