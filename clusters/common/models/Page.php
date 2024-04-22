<?php

namespace common\models;

use Imagine\Image\Box;
use Imagine\Imagick\Imagine;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $url
 * @property integer $status
 * @property string $created_at
 * @property string $image
 * @property string $image_convert
 * @property integer $type
 * @property integer $sort
 *
 * @property PageTranslate[] $pageTranslates
 */
class Page extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const TYPE_MAIN = 1;
    const TYPE_NEWS = 2;
    const TYPE_OTHERS = 3;

    public $file;

    public static function getTypes()
    {
        return [
            self::TYPE_MAIN => "Главное меню",
            self::TYPE_NEWS => "Новости",
            self::TYPE_OTHERS => "Другие"
        ];
    }

    public function getTypeName()
    {
        return array_key_exists($this->type, self::getTypes()) ? self::getTypes()[$this->type] : null;
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => t("Активный"),
            self::STATUS_INACTIVE => t("Не активный"),
        ];
    }

    public function getStatusName()
    {
        return array_key_exists($this->status, self::getStatuses()) ? self::getStatuses()[$this->status] : null;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['status', 'type', 'sort'], 'integer'],
            [['created_at', 'image', 'image_convert'], 'safe'],
            ['titles', 'safe'],
            ['urls', 'safe'],
            ['descriptions', 'safe'],
            ['urls', 'urlValidation'],
            ['file', 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif', 'tif']]
        ];
    }

    public function urlValidation($attribute, $params)
    {
        $return = true;

        foreach ($this->$attribute as $lang => $url) {
            if (!$url) {
                $url = strtolower(rus2translit($this->titles[$lang]));
                $this->$attribute[$lang] = $url;
            }

            $pageTranslate = PageTranslate::findAll(['page_id' => $this->id]);
            $check = PageTranslate::find()->where(['url' => $url]);

            if ($pageTranslate) $check->andWhere(['not in', 'id', ArrayHelper::getColumn($pageTranslate, 'id')]);

            $check = $check->one();

            if ($check) {;
                $this->addError($attribute . '[' . $lang . ']', 'Уникальный URL (' . Lang::findOne($lang)->name . ') занят');
                $return = false;
            }
        }
        return $return;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'type' => 'Type',
            'sort' => 'Sort',
            'titles' => "Наименование",
            'descriptions' => "Описание",
            'urls' => "Уникальный URL",
            'status' => "Статус"
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageTranslates()
    {
        return $this->hasMany(PageTranslate::className(), ['page_id' => 'id']);
    }

    public function getTitles()
    {
        return ArrayHelper::map($this->pageTranslates, 'lang', 'title');
    }

    public function setTitles($val)
    {
        $this->titles = $val;
    }

    public function getUrls()
    {
        return ArrayHelper::map($this->pageTranslates, 'lang', 'url');
    }

    public function setUrls($val)
    {
        $this->urls = $val;
    }

    public function getDescriptions()
    {
        return ArrayHelper::map($this->pageTranslates, 'lang', 'description');
    }

    public function setDescriptions($val)
    {
        $this->descriptions = $val;
    }

    public function getTitlesString()
    {
        return join(' / ', ArrayHelper::getColumn($this->pageTranslates, 'title'));
    }

    public function setTitlesString($val)
    {
        $this->titlesString = $val;
    }

    public function getUrlsString()
    {
        return join(' / ', ArrayHelper::getColumn($this->pageTranslates, 'url'));
    }

    public function setUrlsString($val)
    {
        $this->urlsString = $val;
    }

    public function getDescriptionsString()
    {
        return join(' / ', ArrayHelper::getColumn($this->pageTranslates, 'description'));
    }

    public function setDescriptionsString($val)
    {
        $this->descriptionsString = $val;
    }

    public function setTitle($val)
    {
        $this->title = $val;
    }

    public function getTitle()
    {
        return $this->translate ? $this->translate->title : null;
    }

    public function setUrl($val)
    {
        $this->url = $val;
    }

    public function getUrl()
    {
        return $this->translate ? $this->translate->url : null;
    }

    public function setDescription($val)
    {
        $this->description = $val;
    }

    public function getDescription()
    {
        return $this->translate ? $this->translate->description : null;
    }

    public function getTranslate()
    {
        return $this->hasOne(PageTranslate::className(), ['page_id' => 'id'])->andWhere(['lang' => Yii::$app->languageId]);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (is_array($this->titles)) {
            foreach ($this->titles as $lang => $title) {
                $translate = PageTranslate::findOne(['page_id' => $this->id, 'lang' => $lang]);

                if (!$translate) {
                    $translate = new PageTranslate([
                        'page_id' => $this->id,
                        'lang' => $lang
                    ]);
                }

                $translate->title = $title;
                $translate->description = $this->descriptions[$lang];

                if (isset($this->urls[$lang]) && $this->urls[$lang])
                    $translate->url = $this->urls[$lang];
                else {
                    $translate->url = strtolower(rus2translit($title));
                }

                $translate->save(false);
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    private function deleteFile($image)
    {
        if ($image) {
            if (file_exists(Yii::getAlias("@uploads") . '/page/' . $image)) {
                unlink(Yii::getAlias("@uploads") . '/page/' . $image);
            }

            if (file_exists(Yii::getAlias("@uploads") . '/page/resize/' . $image)) {
                unlink(Yii::getAlias("@uploads") . '/page/resize/' . $image);
            }

            $extension = pathinfo($image, PATHINFO_EXTENSION);

            if (file_exists(Yii::getAlias("@uploads") . '/page/webp/' . str_replace($extension, 'webp', $image))) {

                unlink(Yii::getAlias("@uploads") . '/page/webp/' . str_replace($extension, 'webp', $image));
            }
        }
    }

    public function afterDelete()
    {
        $this->deleteFile($this->image);

        return parent::afterDelete();
    }

    private function saveFile($file)
    {
        $filename = ((int) (microtime(true) * (1000))) . '.' . $file->extension;

        $file->saveAs(Yii::getAlias("@uploads") . "/page/" . $filename);
        $imagine = new Imagine();

        $image = $imagine->open(Yii::getAlias("@uploads") . "/page/" . $filename);

        $ratio = $image->getSize()->getWidth() / $image->getSize()->getHeight();

        $width = 512;
        $height = $width / $ratio;

        $image->thumbnail(new Box($width, $height), \Imagine\Image\ImageInterface::THUMBNAIL_INSET)
            ->strip()
            ->save(Yii::getAlias("@uploads") . "/page/jpg/" . str_replace($file->extension, "jpg", $filename), ['quality' => 80]);

        return $filename;
    }

    public function beforeSave($insert)
    {
        $this->file = UploadedFile::getInstance($this, 'file');

        if ($this->file != null) {

            $this->deleteFile($this->image);

            $filename = $this->saveFile($this->file);

            $this->image = $filename;
            $this->image_convert = str_replace($this->file->extension, "jpg", $filename);
        }

        $this->file = null;

        return parent::beforeSave($insert);
    }
}
