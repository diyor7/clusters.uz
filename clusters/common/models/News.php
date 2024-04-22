<?php

namespace common\models;
use yii\web\UploadedFile;
use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $created_at
 * @property string|null $image
 * @property int $views
 * @property string|null $video
 *
 * @property NewsTranslate[] $newsTranslates
 */
class News extends \yii\db\ActiveRecord
{
    public $file, $vidyo;
    public $titles;
    public $small_descriptions;
    public $descriptions;

   
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'required'],
            [['created_at', 'titles', 'small_descriptions', 'descriptions'], 'safe'],
            [['views'], 'integer'],
            [['image', 'video'], 'string', 'max' => 255],
            ['file', 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif', 'tif']],
            ['vidyo', 'file', 'extensions' => ['mp4', 'avi']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'created_at' => Yii::t('main', 'Created At'),
            'image' => Yii::t('main', 'Image'),
            'views' => Yii::t('main', 'Views'),
            'video' => Yii::t('main', 'Video'),
        ];
    }

    public function getImages()
    {
        return $this->hasMany(NewsImage::className(), ['news_id' => 'id']);
    }

    /**
     * Gets query for [[NewsTranslates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNewsTranslates()
    {
        return $this->hasMany(NewsTranslate::className(), ['news_id' => 'id']);
    }

    public function getTranslate()
    {
        return $this->hasOne(NewsTranslate::className(), ['news_id' => 'id'])->andWhere(['lang_id' => Yii::$app->languageId]);
    }

    public function getTitle()
    {
        return $this->translate ? $this->translate->title : 'no';
    }

    public function getSmallDesc()
    {
        return $this->translate ? $this->translate->small_desc : null;
    }

    public function getDescription()
    {
        return $this->translate ? $this->translate->description : null;
    }

    public function getImageurl()
    {
        return $this->image ? siteUrl() . 'uploads/news/'.$this->image : null;
    }

    public function getVideourl()
    {
        return $this->video ? siteUrl() . 'uploads/news/'.$this->video : null;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (is_array($this->titles)) {
            foreach ($this->titles as $lang => $title) {
                $translate = NewsTranslate::findOne(['news_id' => $this->id, 'lang_id' => $lang]);

                if (!$translate) {
                    $translate = new NewsTranslate([
                        'news_id' => $this->id,
                        'lang_id' => $lang
                    ]);
                }

                $translate->title = $title;
                $translate->small_desc = $this->small_descriptions[$lang];
                $translate->description = $this->descriptions[$lang];

                $translate->save(false);
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }


    public function beforeSave($insert)
    {
        $this->file = UploadedFile::getInstance($this, 'file');

        if ($this->file != null) {

            $filename = ((int) (microtime(true) * (1000))) . '.' . $this->file->extension;

            $this->file->saveAs(Yii::getAlias("@uploads") . "/news/" . $filename);

            $this->image = $filename;
        }

        $this->file = null;

        $this->vidyo = UploadedFile::getInstance($this, 'vidyo');

        if ($this->vidyo != null) {

            $filename = ((int) (microtime(true) * (1000))) . '.' . $this->vidyo->extension;

            $this->vidyo->saveAs(Yii::getAlias("@uploads") . "/news/" . $filename);

            $this->video = $filename;
        }

        $this->vidyo = null;

        return parent::beforeSave($insert);
    }

    public function afterDelete()
    {
        if (file_exists(Yii::getAlias("@uploads") . '/news/' . $this->image)) {
            unlink(Yii::getAlias("@uploads") . '/news/' . $this->image);
        }
        return parent::afterDelete();
    }

   
}
