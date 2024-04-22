<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "unit".
 *
 * @property int $id
 * @property int|null $sort
 *
 * @property AuctionTn[] $auctionTns
 * @property UnitTranslate[] $unitTranslates
 */
class Unit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
            ['titles', 'required'],
            ['titles', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sort' => 'Sort',
        ];
    }

    /**
     * Gets query for [[AuctionTns]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuctionTns()
    {
        return $this->hasMany(AuctionTn::className(), ['unit_id' => 'id']);
    }

    /**
     * Gets query for [[UnitTranslates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnitTranslates()
    {
        return $this->hasMany(UnitTranslate::className(), ['unit_id' => 'id']);
    }


    public function setTitle($val)
    {
        $this->title = $val;
    }

    public function getTitle()
    {
        return $this->translate ? $this->translate->title : null;
    }

    public function getTranslate()
    {
        return $this->hasOne(UnitTranslate::className(), ['unit_id' => 'id'])->andWhere(['unit_translate.lang' => Yii::$app->languageId]);
    }

    public function getTitles()
    {
        return ArrayHelper::map($this->unitTranslates, 'lang', 'title');
    }

    public function setTitles($val)
    {
        $this->titles = $val;
    }

    public function getTitlesString()
    {
        return join(' / ', ArrayHelper::getColumn($this->unitTranslates, 'title'));
    }

    public function setTitlesString($val)
    {
        $this->titlesString = $val;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (is_array($this->titles)) {
            foreach ($this->titles as $lang => $title) {
                $translate = UnitTranslate::findOne(['unit_id' => $this->id, 'lang' => $lang]);

                if (!$translate) {
                    $translate = new UnitTranslate([
                        'unit_id' => $this->id,
                        'lang' => $lang
                    ]);
                }

                $translate->title = $title;
                $translate->save();
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }
}
