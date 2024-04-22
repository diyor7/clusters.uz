<?php

namespace common\models;
use yii\web\UploadedFile;
use Yii;

/**
 * This is the model class for table "news_image".
 *
 * @property int $id
 * @property int $news_id
 * @property string $image
 * @property int $sort
 *
 * @property News $news
 */
class NewsImage extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['news_id', 'image', 'sort'], 'required'],
            [['news_id', 'sort'], 'integer'],
            [['image'], 'string', 'max' => 255],
            ['file', 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif', 'tif']],
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
            'news_id' => Yii::t('main', 'News ID'),
            'image' => Yii::t('main', 'Image'),
            'sort' => Yii::t('main', 'Sort'),
        ];
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

    public function getImageurl()
    {
        return $this->image ? siteUrl() . 'uploads/news/'.$this->image : null;
    }

    // public function beforeSave($insert)
    // {
       

    //     return parent::beforeSave($insert);
    // }

    public function afterDelete()
    {
        if (file_exists(Yii::getAlias("@uploads") . '/news/' . $this->image)) {
            unlink(Yii::getAlias("@uploads") . '/news/' . $this->image);
        }
        return parent::afterDelete();
    }
}
