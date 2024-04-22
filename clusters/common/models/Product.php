<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
use Imagine\Image\Box;
use Imagine\Imagick\Imagine;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $tovar_id
 * @property integer $tn_id
 * @property integer $quantity
 * @property string $vendor_code
 * @property double $price_old
 * @property double $price
 * @property string $image
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $company_id
 * @property string $time_to_archive
 *
 * @property Cart[] $carts
 * @property Category $category
 * @property Company $company
 * @property ProductProperty[] $getproductProperties
 * @property ProductTranslate[] $productTranslates
 */
class Product extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_MODERATING = 2;
    const STATUS_MODERATING_AGAIN = 3;
    const STATUS_NOT_MODERATED = 4;
    const STATUS_BALANCE_WAITING_TILL_MODERATING = 5;

    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => t("Актив"),
            self::STATUS_INACTIVE => t("Не актив"),
            self::STATUS_MODERATING => t("Модеруется"),
            self::STATUS_BALANCE_WAITING_TILL_MODERATING => t("Недостаточно средств"),
            self::STATUS_MODERATING_AGAIN => t("Повторная модерация"),
            self::STATUS_NOT_MODERATED => t("Не прошел модерацию"),
        ];
    }

    public function getStatusName()
    {
        return array_key_exists($this->status, self::getStatuses()) ? self::getStatuses()[$this->status] : null;
    }

    public function getStatusClass()
    {
        switch ($this->status) {
            case self::STATUS_MODERATING:
                return 'item__badge--status-1';
            case self::STATUS_BALANCE_WAITING_TILL_MODERATING:
                return 'item__badge--status-1';
            case self::STATUS_ACTIVE:
                return 'item__badge--status-3';
            case self::STATUS_INACTIVE:
                return 'item__badge--status-2';
            case self::STATUS_MODERATING_AGAIN:
            default:
                return 'item__badge--status-1';
        }
    }

    const DELIVERY_PERIOD_TYPE_DAY = 1;
    const DELIVERY_PERIOD_TYPE_MONTH = 2;
    const DELIVERY_PERIOD_TYPE_YEAR = 3;

    public static function getDeliveryPeriodTypes()
    {
        return [
            self::DELIVERY_PERIOD_TYPE_DAY => t('день'),
            self::DELIVERY_PERIOD_TYPE_MONTH => t('месяц'),
            self::DELIVERY_PERIOD_TYPE_YEAR => t('год'),
        ];
    }

    public function getDeliveryPeriodType()
    {
        return array_key_exists($this->delivery_period_type, self::getDeliveryPeriodTypes()) ? self::getDeliveryPeriodTypes()[$this->delivery_period_type] : null;
    }

    public function getDeliveryPeriod()
    {
        if (!$this->delivery_period) return null;

        if ($this->delivery_period_type == self::DELIVERY_PERIOD_TYPE_DAY)
            return plural($this->delivery_period, t("день"), t("дня"), t("дней"));
        else if ($this->delivery_period_type == self::DELIVERY_PERIOD_TYPE_MONTH) {
            return plural($this->delivery_period, t("месяц"), t("месяца"), t("месяцев"));
        } else {
            return plural($this->delivery_period, t("год"), t("года"), t("лет"));
        }
    }

    public function getDeliveryType()
    {
        return array_key_exists($this->delivery_type, Order::getDeliveryTypes()) ? Order::getDeliveryTypes()[$this->delivery_type] : null;
    }

    const WARRANTY_PERIOD_TYPE_DAY = 1;
    const WARRANTY_PERIOD_TYPE_MONTH = 2;
    const WARRANTY_PERIOD_TYPE_YEAR = 3;

    public static function getWarrantyPeriodTypes()
    {
        return [
            self::WARRANTY_PERIOD_TYPE_DAY => t('день'),
            self::WARRANTY_PERIOD_TYPE_MONTH => t('месяц'),
            self::WARRANTY_PERIOD_TYPE_YEAR => t('год'),
        ];
    }

    public function getWarrantyPeriodType()
    {
        return array_key_exists($this->delivery_period_type, self::getWarrantyPeriodTypes()) ? self::getWarrantyPeriodTypes()[$this->delivery_period_type] : null;
    }

    public function getWarrantyPeriod()
    {
        if (!$this->warranty_period) return null;

        if ($this->warranty_period_type == self::WARRANTY_PERIOD_TYPE_DAY)
            return plural($this->warranty_period, t("день"), t("дня"), t("дней"));
        else if ($this->warranty_period_type == self::WARRANTY_PERIOD_TYPE_MONTH) {
            return plural($this->warranty_period, t("месяц"), t("месяца"), t("месяцев"));
        } else {
            return plural($this->warranty_period, t("год"), t("года"), t("лет"));
        }
    }

    public function getWarrantyType()
    {
        return array_key_exists($this->delivery_type, Product::getWarrantyPeriodTypes()) ? Product::getWarrantyPeriodTypes()[$this->delivery_type] : null;
    }

    public $user_id;

    public $property_values = [];
    public $properties = [];

    public $file;
    public $files = [];

    public $fav_count;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[/*'title',*/ 'description', 'delivery_type', 'category_id', 'unit_id', 'tovar_id'], 'required'/*, 'on' => "seller"*/],
            [['quantity', 'price', 'created_at', 'updated_at', 'company_id', 'delivery_period', 'delivery_period_type', 'warranty_period', 'warranty_period_type', 'min_order'], 'required'],
            [['category_id', 'quantity', 'status', 'company_id', 'min_order', 'unit_id', 'tovar_id'], 'integer'],

            ['min_order', 'compare', 'compareAttribute' => 'quantity', 'operator' => "<=", 'message' => t("«{attribute}» должен быть меньше или равен на «{compareAttribute}»"), 'on' => 'seller'],
            // ['price_old', 'compare', 'compareAttribute' => 'price', 'operator' => ">"],

            [['price_old', 'price'], 'number'],
            [['warranty_period', 'delivery_period'], 'integer', 'max' => 1264],
            [['created_at', 'updated_at', 'reason', 'time_to_archive'], 'safe'],
            [['vendor_code'], 'string', 'max' => 70],
            [['image', 'delivery_address'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['tovar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['tovar_id' => 'id']],
            [['tn_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tn::className(), 'targetAttribute' => ['tn_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            ['file', 'file', 'extensions' => ['jpg', 'jpeg', 'webp', 'png']],
            ['files', 'file', 'maxFiles' => 4, 'extensions' => ['jpg', 'jpeg', 'webp', 'png']],
            ['properties', 'safe'],
            ['files', 'required', 'on' => 'create'],
            ['delivery_regions', 'safe'],
            ['fav_count', 'safe'],
            ['titles', 'safe'],
            ['property_values', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => t("Категория"),
            'category' => t("Категория"),
            'tovar_id' => t("Наименование товара"),
            'tn_id' => t("ТН ВЭД"),
            'quantity' => t("В наличии"),
            'vendor_code' => t("Артикул"),
            'price_old' => t("Старая цена"),
            'price' => t("Цена за единицу"),
            'image' => t("Картинка"),
            'created_at' => t("Дата добавления"),
            'updated_at' => t("Дата редактирования"),
            'status' => t("Статус"),
            'statusName' => t("Статус"),
            'company_id' => t("Пользователь"),
            'unit_id' => t("Единица измерения"),
            'title' => t("Наименование"),
            'description' => t("Описание"),
            'file' => t("Картинка"),
            'files' => t("Картинки"),
            'min_order' => t("Минимальный заказ"),
            'delivery_period' => t("Срок поставки"),
            'delivery_period_type' => t("Тип поставки"),
            'delivery_regions' => t("Доставка по регионам"),
            'delivery_type' => t("Тип доставки"),
            'delivery_address' => t("Адрес получения"),
            'warranty_period' => t("Гарантийное и техническое обслуживание"),
            'warranty_period_type' => t("Тип срока"),
            'reason' => t("Причина (не прошел модерацию)"),
        ];
    }

    public function getRating()
    {
        return ProductReview::find()->where(['product_id' => $this->id])->average('stars') + 0;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorite::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductReviews()
    {
        return $this->hasMany(ProductReview::className(), ['product_id' => 'id']);
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
    public function getTovar()
    {
        return $this->hasOne(Category::className(), ['id' => 'tovar_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTn()
    {
        return $this->hasOne(Tn::className(), ['id' => 'tn_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Company::className(), ['id' => 'user_id']);
    }

    public function getDelivery_regions()
    {
        return ArrayHelper::getColumn($this->productDeliveryRegions, 'region_id');
    }

    public function getDeliveryRegions()
    {
        return count($this->productDeliveryRegions) > 0 ? join(", ", ArrayHelper::getColumn($this->productDeliveryRegions, 'region.title')) : t("Нет");
    }

    public function setDelivery_regions($val)
    {
        return $this->delivery_regions = $val;
    }

    public function getTitles()
    {
        return ArrayHelper::map($this->productTranslates, 'lang', 'title');
    }

    public function setTitles($val)
    {
        $this->titles = $val;
    }

    public function getDescriptions()
    {
        return ArrayHelper::map($this->productTranslates, 'lang', 'description');
    }

    public function setDescriptions($val)
    {
        $this->descriptions = $val;
    }

    public function getTitle()
    {
        return $this->tovar ? $this->tovar->title : ($this->translate ? $this->translate->title : null);
    }

    public function setTitle($val)
    {
        return $this->title = $val;
    }

    public function getTitlesString()
    {
        return join(' / ', ArrayHelper::getColumn($this->productTranslates, 'title'));
    }

    public function setTitlesString($val)
    {
        $this->titlesString = $val;
    }

    public function getDescription()
    {
        return $this->translate ? $this->translate->description : null;
    }

    public function setDescription($val)
    {
        return $this->description = $val;
    }

    public function getPropertiesCache()
    {
        $data = [];

        foreach ($this->productProperties as $productProperty) {
            if ($productProperty->propertyValue ? $productProperty->propertyValue->value : $productProperty->value) {
                $data[] = [
                    'property' => $productProperty->property->ruTitle,
                    'value' => $productProperty->propertyValue ? $productProperty->propertyValue->value : $productProperty->value,
                    'count_unit' => $productProperty->property->count_unit
                ];
            }
        }

        return $data;
    }

    public function getTranslate()
    {
        return $this->hasOne(ProductTranslate::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductProperties()
    {
        return $this->hasMany(ProductProperty::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductDeliveryRegions()
    {
        return $this->hasMany(ProductDeliveryRegion::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTranslates()
    {
        return $this->hasMany(ProductTranslate::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImage::className(), ['product_id' => 'id']);
    }

    public function getIsFavorite()
    {
        return !!Favorite::findOne(['user_id' => Yii::$app->user->id, 'product_id' => $this->id]);
    }

    public function getCode()
    {
        return $this->tn ? $this->tn->code : "";
    }

    public function getCtitle()
    {
        return $this->category ? $this->category->title : "";
    }

    public function getPath()
    {
        if (!$this->image) {
            if (count($this->productImages) > 0) {
                return $this->productImages[0]->path;
            }

            return ($_SERVER['SERVER_NAME'] == "control.clusters.uz" ? "https://clusters.uz/" : siteUrl()) . 'img/default.jpg';
        }

        $extension = pathinfo($this->image, PATHINFO_EXTENSION);

        if (file_exists(Yii::getAlias("@uploads") . '/product/webp/' . str_replace($extension, 'webp', $this->image))) {
            return ($_SERVER['SERVER_NAME'] == "control.clusters.uz" ? "https://clusters.uz/" : siteUrl()) . "uploads/product/webp/" . str_replace($extension, 'webp', $this->image);
        }

        return ($_SERVER['SERVER_NAME'] == "control.clusters.uz" ? "https://clusters.uz/" : siteUrl()) . "uploads/product/webp/" . $this->image;
    }

    public function getOriginalPath()
    {
        if (!$this->image) {
            return siteUrl() . 'img/default.jpg';
        }

        return siteUrl() . "uploads/product/" . $this->image;
    }

    public function getUrl()
    {
        return strtolower(preg_replace("/[^-\w]+/", "", rus2translit($this->title))) . "--" . $this->id;
    }

    public function beforeSave($insert)
    {
        $this->files = UploadedFile::getInstances($this, 'files');

        if ($this->image == null && count($this->files) > 0) {
            $file = $this->files[0];
            $this->deleteFile($this->image);
            $filename = $this->saveFile($file);
            $this->image = $filename;

            $this->files[0] = null;
        }

        if (!$this->isNewRecord) {
            $this->updated_at = date("Y-m-d H:i:s");
        }

        // var_dump($this->category_id);
        // die();

        // if (!$this->category_id) {
        //     $this->category_id = $this->tn ? $this->tn->category_id : null;
        // }

        // $this->file = UploadedFile::getInstance($this, 'file');

        // if ($this->file != null) {

        //     $this->deleteFile($this->image);

        //     $filename = $this->saveFile($this->file);

        //     $this->image = $filename;
        // }

        // $this->file = null;

        // if ($this->isNewRecord) {
        //     if ($this->status == self::STATUS_ACTIVE) {
        //         $this->status = self::STATUS_MODERATING;
        //     }
        // }

        return parent::beforeSave($insert);
    }

    private function saveFile($file)
    {
        if ($file != null) {
            $filename = ((int) (microtime(true) * (1000))) . '.' . $file->extension;

            $file->saveAs(Yii::getAlias("@uploads") . "/product/" . $filename);
            $imagine = new Imagine();

            $image = $imagine->open(Yii::getAlias("@uploads") . "/product/" . $filename);

            if ($image->getSize()->getWidth() > 450)
                $image->resize(new Box(450, 450));

            if ($file->extension != 'webp') {
                $image->save(Yii::getAlias("@uploads") . "/product/resize/" . $filename);

                convertImageToWebP(Yii::getAlias("@uploads") . "/product/resize/" . $filename, Yii::getAlias("@uploads") . "/product/webp/" . str_replace($file->extension, "webp", $filename));
            } else {
                $image->save(Yii::getAlias("@uploads") . "/product/webp/" . str_replace($file->extension, "webp", $filename));
            }

            return $filename;
        }
        return null;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->tovar) {
            foreach (Lang::find()->all() as $lang) {
                $translate = ProductTranslate::findOne(['product_id' => $this->id, 'lang' => $lang->id]);

                if (!$translate) {
                    $translate = new ProductTranslate([
                        'product_id' => $this->id,
                        'lang' => $lang->id
                    ]);
                }

                $translate->title = $this->tovar->title;
                $translate->description = $this->description;
                $translate->save();
            }
        } else if ($this->title) {
            foreach (Lang::find()->all() as $lang) {
                $translate = ProductTranslate::findOne(['product_id' => $this->id, 'lang' => $lang->id]);

                if (!$translate) {
                    $translate = new ProductTranslate([
                        'product_id' => $this->id,
                        'lang' => $lang->id
                    ]);
                }

                $translate->title = $this->title;
                $translate->description = $this->description;
                $translate->save();
            }
        } else if (is_array($this->titles)) {
            foreach ($this->titles as $lang => $title) {
                $translate = ProductTranslate::findOne(['product_id' => $this->id, 'lang' => $lang]);

                if (!$translate) {
                    $translate = new ProductTranslate([
                        'product_id' => $this->id,
                        'lang' => $lang
                    ]);
                }

                $translate->title = $title;
                $translate->description = isset($this->descriptions[$lang]) ? $this->descriptions[$lang] : null;
                $translate->save(false);
            }
        }

        if (is_array($this->properties) && count($this->properties) > 0) {
            foreach ($this->properties as $property_id => $value) {
                $product_property = ProductProperty::findOne(['product_id' => $this->id, 'property_id' => $property_id]);

                if (!$product_property) {
                    $product_property = new ProductProperty(['product_id' => $this->id, 'property_id' => $property_id]);
                }

                $product_property->value = $value;
                $product_property->property_value_id = null;
                $product_property->save();
            }
        }

        if (is_array($this->property_values) && count($this->property_values) > 0) {
            foreach ($this->property_values as $property_id => $value_id) {
                $product_property = ProductProperty::findOne(['product_id' => $this->id, 'property_id' => $property_id]);

                if (!$product_property) {
                    $product_property = new ProductProperty(['product_id' => $this->id, 'property_id' => $property_id]);
                }

                $product_property->value = null;
                $product_property->property_value_id = (int) $value_id;
                $product_property->save();
            }
        }

        if (is_array($this->delivery_regions) && count($this->delivery_regions) > 0) {
            ProductDeliveryRegion::deleteAll(['product_id' => $this->id]);

            foreach ($this->delivery_regions as $region_id) {
                $product_delivery_country = ProductDeliveryRegion::findOne(['product_id' => $this->id, 'region_id' => $region_id]);

                if (!$product_delivery_country) {
                    $product_delivery_country = new ProductDeliveryRegion(['product_id' => $this->id, 'region_id' => $region_id]);
                }

                $product_delivery_country->save();
            }
        }

        // $this->files = UploadedFile::getInstances($this, 'files');

        if (count($this->files) > 0) {
            foreach ($this->files as $index => $file) {
                $filename = $this->saveFile($file);

                $product_image = new ProductImage([
                    'product_id' => $this->id,
                    'filename' => $filename
                ]);

                $product_image->save();
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    public function deleteFile($image)
    {
        if ($image) {
            if (file_exists(Yii::getAlias("@uploads") . '/product/' . $image)) {
                unlink(Yii::getAlias("@uploads") . '/product/' . $image);
            }

            if (file_exists(Yii::getAlias("@uploads") . '/product/resize/' . $image)) {
                unlink(Yii::getAlias("@uploads") . '/product/resize/' . $image);
            }

            $extension = pathinfo($image, PATHINFO_EXTENSION);

            if (file_exists(Yii::getAlias("@uploads") . '/product/webp/' . str_replace($extension, 'webp', $image))) {

                unlink(Yii::getAlias("@uploads") . '/product/webp/' . str_replace($extension, 'webp', $image));
            }
        }
    }

    public function afterDelete()
    {
        $this->deleteFile($this->image);

        foreach (ProductImage::findAll(['product_id' => $this->id]) as $product_image) {
            $this->deleteFile($product_image->filename);
            $product_image->delete();
        }

        return parent::afterDelete();
    }
}
