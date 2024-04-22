<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "condition".
 *
 * @property int $id
 * @property int|null $sort
 *
 * @property AuctionCondition[] $auctionConditions
 * @property ConditionTranslate[] $conditionTranslates
 */
class Condition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'condition';
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
            'sort' => 'Порядок действий (0->1000)',
            'titles' => "Наименование",
            'title' => "Наименование",
        ];
    }

    /**
     * Gets query for [[AuctionConditions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuctionConditions()
    {
        return $this->hasMany(AuctionCondition::className(), ['condition_id' => 'id']);
    }

    /**
     * Gets query for [[ConditionTranslates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConditionTranslates()
    {
        return $this->hasMany(ConditionTranslate::className(), ['condition_id' => 'id']);
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
        return $this->hasOne(ConditionTranslate::className(), ['condition_id' => 'id'])->andWhere(['condition_translate.lang' => Yii::$app->languageId]);
    }

    public function getTitles()
    {
        return ArrayHelper::map($this->conditionTranslates, 'lang', 'title');
    }

    public function setTitles($val)
    {
        $this->titles = $val;
    }

    public function getTitlesString()
    {
        return join(' / ', ArrayHelper::getColumn($this->conditionTranslates, 'title'));
    }

    public function setTitlesString($val)
    {
        $this->titlesString = $val;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (is_array($this->titles)) {
            foreach ($this->titles as $lang => $title) {
                $translate = ConditionTranslate::findOne(['condition_id' => $this->id, 'lang' => $lang]);

                if (!$translate) {
                    $translate = new ConditionTranslate([
                        'condition_id' => $this->id,
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
