<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "region".
 *
 * @property integer $id
 *
 * @property RegionTranslate[] $regionTranslates
 */
class Region extends \yii\db\ActiveRecord
{
    const TYPE_GENERAL = 1;
    const TYPE_PRODUCT = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['parent_id', 'integer'],
            ['type', 'integer'],
            ['titles', 'required'],
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
            'parent_id' => 'Родитель ID',
            'titles' => "Наименование",
            'titlesString' => "Наименовании",
        ];
    }

    public static function getTree()
    {
        $tree = [];


        foreach (Region::find()->where('parent_id is null and type = :type', [':type' => self::TYPE_GENERAL])->all() as $parent) {

            $children = $parent->getRegions()->all();

            if (count($children) > 0)
                $tree[$parent->title] = ArrayHelper::map($children, 'id', 'title');
            else
                $tree[$parent->id] = $parent->title;
        }

        return $tree;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegionTranslates()
    {
        return $this->hasMany(RegionTranslate::className(), ['region_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegions()
    {
        return $this->hasMany(Region::className(), ['parent_id' => 'id']);
    }

    public function getTranslate()
    {
        return $this->hasOne(RegionTranslate::className(), ['region_id' => 'id'])->andWhere(['region_translate.language_id' => Yii::$app->languageId->id]);
    }

    public function getParent()
    {
        return $this->hasOne(Region::className(), ['id' => 'parent_id']);
    }

    public function setTitle($val)
    {
        $this->title = $val;
    }

    public function getTitle()
    {
        return $this->translate ? $this->translate->title : null;
    }

    public function getTitles()
    {
        return ArrayHelper::map($this->regionTranslates, 'lang', 'title');
    }

    public function setTitles($val)
    {
        $this->titles = $val;
    }

    public function getTitlesString()
    {
        return join(' / ', ArrayHelper::getColumn($this->regionTranslates, 'title'));
    }

    public function setTitlesString($val)
    {
        $this->titlesString = $val;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (is_array($this->titles)) {
            foreach ($this->titles as $lang => $title) {
                $translate = RegionTranslate::findOne(['region_id' => $this->id, 'language_id' => $lang]);

                if (!$translate) {
                    $translate = new RegionTranslate([
                        'region_id' => $this->id,
                        'language_id' => $lang
                    ]);
                }

                $translate->title = $title;
                $translate->save();
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }
}
