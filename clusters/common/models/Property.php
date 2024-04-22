<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "property".
 *
 * @property integer $id
 * @property integer $category_id
 *
 * @property ProductProperty[] $productProperties
 * @property Category $category
 * @property PropertyTranslate[] $propertyTranslates
 * @property PropertyValue[] $propertyValues
 */
class Property extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'property';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            ['titles', 'safe'],
            ['count_units', 'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'count_unit' => 'Count Unit',
            'category_id' => 'Category ID',
            'titles' => "Наименование",
            'count_units' => "Единица измерения",
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductProperties()
    {
        return $this->hasMany(ProductProperty::className(), ['property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyTranslates()
    {
        return $this->hasMany(PropertyTranslate::className(), ['property_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyValues()
    {
        return $this->hasMany(PropertyValue::className(), ['property_id' => 'id']);
    }


    public function getTitles()
    {
        return ArrayHelper::map($this->propertyTranslates, 'lang', 'title');
    }

    public function setTitles($val)
    {
        $this->titles = $val;
    }

    public function getCount_units()
    {
        return ArrayHelper::map($this->propertyTranslates, 'lang', 'count_unit');
    }

    public function setCount_units($val)
    {
        $this->count_units = $val;
    }

    public function getTitlesString()
    {
        return join(' / ', ArrayHelper::getColumn($this->propertyTranslates, 'title'));
    }

    public function getCount_unitsString()
    {
        return join(' / ', ArrayHelper::getColumn($this->propertyTranslates, 'count_unit'));
    }

    public function setTitle($val)
    {
        $this->title = $val;
    }

    public function getTitle()
    {
        return $this->translate ? $this->translate->title : null;
    }

    public function getRuTitle()
    {
        return $this->ruTranslate ? $this->ruTranslate->title : null;
    }

    public function getCount_unit()
    {
        return $this->translate ? $this->translate->count_unit : null;
    }

    public function getTranslate()
    {
        return $this->hasOne(PropertyTranslate::className(), ['property_id' => 'id'])->andWhere(['lang' => \Yii::$app->languageId]);
    }

    public function getRuTranslate()
    {
        $language = Lang::findOne(['url' => 'ru']);

        return $language ? $this->hasOne(PropertyTranslate::className(), ['property_id' => 'id'])->andWhere(['lang' => $language->id]) : null;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (is_array($this->titles)) {
            foreach ($this->titles as $lang => $title) {
                $translate = PropertyTranslate::findOne(['property_id' => $this->id, 'lang' => $lang]);

                if (!$translate) {
                    $translate = new PropertyTranslate([
                        'property_id' => $this->id,
                        'lang' => $lang
                    ]);
                }

                $translate->title = $title;

                if (isset($this->count_units[$lang]))
                    $translate->count_unit = $this->count_units[$lang];

                $translate->save();
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }
}
