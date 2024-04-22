<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use Imagine\Image\Box;
use Imagine\Imagick\Imagine;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $image
 * @property integer $parent_id
 *
 * @property CategoryTranslate[] $categoryTranslates
 * @property Product[] $products
 * @property Property[] $properties
 */
class Category2 extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const TYPE_GENERAL = 1;
    const TYPE_TN = 2;
    const TYPE_EMAGAZIN = 3;

    public $product_count;

    public $file;

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

    public static function getTypes()
    {
        return [
            // self::TYPE_GENERAL => t("Обычный"),
            // self::TYPE_TN => t("ТН ВЭД"),
            self::TYPE_EMAGAZIN => t("Классификатор"),
        ];
    }

    public function getTypeName()
    {
        return array_key_exists($this->status, self::getTypes()) ? self::getTypes()[$this->status] : null;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category3';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // ['titles', 'required'],
            [['parent_id', 'status', 'sort', 'type'], 'integer'],
            [['image', 'classifier'], 'string', 'max' => 255],
            ['titles', 'safe'],
            ['product_count', 'safe'],
            ['classifier', 'unique'],
            ['file', 'file', 'extensions' => ['jpg', 'jpeg', 'webp', 'png', 'gif', 'tif']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'parent_id' => 'Parent ID',
            'titles' => "Наименование",
            'status' => "Статус",
            'type' => "Тип",
        ];
    }

    public static function getProductsWithCount()
    {
        return self::find()
            ->select(['category.*, (select count(*) from product where (product.category_id = category.id or product.category_id in (select id from category c where c.parent_id = category.id)) and product.status = 1) as product_count'])
            ->where('parent_id is null and category.type = 1')->orderBy('sort desc, product_count desc')->all();
    }

    public function getTitles()
    {
        return ArrayHelper::map($this->categoryTranslates, 'lang', 'title');
    }

    public function setTitles($val)
    {
        $this->titles = $val;
    }

    public function getTitlesString()
    {
        return join(' / ', ArrayHelper::getColumn($this->categoryTranslates, 'title'));
    }

    public function setTitlesString($val)
    {
        $this->titlesString = $val;
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
        return $this->hasOne(CategoryTranslate2::className(), ['category_id' => 'id'])->andWhere(['lang' => Yii::$app->languageId]);
    }

    public function getParent()
    {
        return $this->hasOne(Category2::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(self::className(), ['parent_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryTranslates()
    {
        return $this->hasMany(CategoryTranslate::className(), ['category_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperties()
    {
        return $this->hasMany(Property::className(), ['category_id' => 'id']);
    }

    public function getUrl()
    {
        return strtolower(rus2translit($this->title)) . "--" . $this->id;
    }

    public static function getTree()
    {
        $tree = [];

        foreach (Category::find()->where('parent_id is null and category.type = 1 and status = :status', [':status' => self::STATUS_ACTIVE])->all() as $parent) {
            $children = $parent->getCategories()->andWhere(['status' => self::STATUS_ACTIVE])->all();

            if (count($children) > 0)
                $tree[$parent->title] = ArrayHelper::map($children, 'id', 'title');
            else
                $tree[$parent->id] = $parent->title;
        }

        return $tree;
    }

    public function beforeSave($insert)
    {
        $this->file = UploadedFile::getInstance($this, 'file');

        if ($this->file != null) {

            $this->deleteAllFiles();

            $filename = ((int) (microtime(true) * (1000))) . '.' . $this->file->extension;

            $this->file->saveAs(Yii::getAlias("@uploads") . "/category/" . $filename);
            $imagine = new Imagine();

            $image = $imagine->open(Yii::getAlias("@uploads") . "/category/" . $filename);

            if ($image->getSize()->getWidth() > 200)
                $image->resize(new Box(200, 200));

            if ($this->file->extension != 'webp') {
                $image->save(Yii::getAlias("@uploads") . "/category/resize/" . $filename);

                convertImageToWebP(Yii::getAlias("@uploads") . "/category/resize/" . $filename, Yii::getAlias("@uploads") . "/category/webp/" . str_replace($this->file->extension, "webp", $filename));
            } else {
                $image->save(Yii::getAlias("@uploads") . "/category/webp/" . str_replace($this->file->extension, "webp", $filename));
            }

            $this->image = $filename;
        }

        $this->file = null;

        return parent::beforeSave($insert);
    }

    public function getPath()
    {
        if (!$this->image) {
            return siteUrl() . 'img/default.jpg';
        }

        return siteUrl() . 'uploads/category/' . $this->image;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (is_array($this->titles)) {
            foreach ($this->titles as $lang => $title) {
                $translate = CategoryTranslate::findOne(['category_id' => $this->id, 'lang' => $lang]);

                if (!$translate) {
                    $translate = new CategoryTranslate([
                        'category_id' => $this->id,
                        'lang' => $lang
                    ]);
                }

                $translate->title = $title;
                $translate->save();
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    private function deleteAllFiles()
    {
        if ($this->image && file_exists(Yii::getAlias("@uploads") . '/category/' . $this->image)) {
            unlink(Yii::getAlias("@uploads") . '/category/' . $this->image);
        }

        if ($this->image && file_exists(Yii::getAlias("@uploads") . '/category/resize/' . $this->image)) {
            unlink(Yii::getAlias("@uploads") . '/category/resize/' . $this->image);
        }

        $extension = pathinfo($this->image, PATHINFO_EXTENSION);

        if ($this->image && file_exists(Yii::getAlias("@uploads") . '/category/webp/' . str_replace($extension, 'webp', $this->image))) {

            unlink(Yii::getAlias("@uploads") . '/category/webp/' . str_replace($extension, 'webp', $this->image));
        }
    }

    public function afterDelete()
    {
        $this->deleteAllFiles();

        return parent::afterDelete();
    }
}
