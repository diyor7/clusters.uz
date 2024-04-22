<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news_translate".
 *
 * @property int $id
 * @property int $lang_id
 * @property int $news_id
 * @property string $title
 * @property string $small_desc
 * @property string $description
 *
 * @property Lang $lang
 * @property News $news
 */
class NewsTranslate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_translate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lang_id', 'news_id', 'title', 'small_desc', 'description'], 'required'],
            [['lang_id', 'news_id'], 'integer'],
            [['description'], 'string'],
            [['title', 'small_desc'], 'string', 'max' => 255],
            [['lang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::className(), 'targetAttribute' => ['lang_id' => 'id']],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::className(), 'targetAttribute' => ['news_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'lang_id' => Yii::t('main', 'Lang ID'),
            'news_id' => Yii::t('main', 'News ID'),
            'title' => Yii::t('main', 'Title'),
            'small_desc' => Yii::t('main', 'Small Desc'),
            'description' => Yii::t('main', 'Description'),
        ];
    }

    /**
     * Gets query for [[Lang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'lang_id']);
    }

    /**
     * Gets query for [[News]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }
}
