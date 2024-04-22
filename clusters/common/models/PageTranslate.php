<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "page_translate".
 *
 * @property integer $id
 * @property integer $page_id
 * @property string $title
 * @property string $description
 * @property integer $lang
 *
 * @property Page $page
 */
class PageTranslate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_translate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'title', 'description', 'lang'], 'required'],
            [['page_id', 'lang'], 'integer'],
            [['url'], 'string', 'max' => 255],
//            [['url'], 'unique'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'title' => 'Title',
            'description' => 'Description',
            'lang' => 'Lang',
            'url' => 'Url',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }
}
