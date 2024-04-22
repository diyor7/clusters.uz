<?php

namespace common\models\organisation\agmk;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property string|null $price
 * @property string|null $code
 * @property int|null $views
 * @property int $units_measure_id
 * @property int $quarter_id
 * @property string|null $description
 * @property int|null $status
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property Images[] $images
 * @property Category $category
 * @property Quarter $quarter
 * @property UnitsMeasure $unitsMeasure
 */
class Product extends \yii\db\ActiveRecord
{
    public $file;
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    const TYPE_IMPORT = 0;
    const TYPE_ISSUED = 1;
    const TYPE_INMARKET = 2;
    const TYPE_SERVICES = 3;

    const CURRENCY_DOLLAR = 1;
    const CURRENCY_EVRO = 2;
    const CURRENCY_RUBL = 3;
    const CURRENCY_SUM = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agmk.product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['name', 'category_id', 'company_id', 'units_measure_id'], 'required'],
            [['category_id', 'views', 'company_id', 'type', 'status'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 500],
            [['name','need_year','place','quality','pdf'], 'string', 'max' => 255],
            [['units_measure_id'], 'string', 'max' => 50],
            [['price', 'code', 'currency', 'year'], 'string', 'max' => 45],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
//            [['quarter_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quarter::className(), 'targetAttribute' => ['quarter_id' => 'id']],
            [['quarter_id'], 'safe'],
//            [['units_measure_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnitsMeasure::className(), 'targetAttribute' => ['units_measure_id' => 'id']],
            ['file', 'file', 'skipOnEmpty' => true,'maxSize' => 1024 * 1024 * 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('frontend', 'Название'),
            'category_id' => Yii::t('frontend', 'Категория ID'),
            'price' => Yii::t('frontend', 'Цена'),
            'code' => Yii::t('frontend', 'ТИФ ТН коди'),
            'views' => Yii::t('frontend', 'Views'),
            'company_id' => Yii::t('frontend', 'Компания'),
            'need_year' => Yii::t('frontend', 'Производственная мощность в год'),
            'feature_id' => Yii::t('frontend', 'Характер ID'),
            'units_measure_id' => Yii::t('frontend', 'Единицы измерения ID'),
            'quarter_id' => Yii::t('frontend', 'Квартал ID'),
            'description' => Yii::t('frontend', 'Описание'),
            'status' => Yii::t('frontend', 'Status'),
            'currency' => Yii::t('frontend', 'Валюта'),
            'year' => Yii::t('frontend', 'Год последний закупки'),
            'created_at' => Yii::t('frontend', 'Дата добавление'),
            'updated_at' => Yii::t('frontend', 'Дата редактирование'),
            'pdf' => Yii::t('frontend', 'продукты pdf'),
            'file' => Yii::t('frontend', 'продукты pdf'),
            'place' => Yii::t('frontend', 'Место эксплуатации'),
            'quality' => Yii::t('frontend', 'Требуемый стандарт качества'),
        ];
    }

    /**
     * Gets query for [[Images]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Images::class, ['product_id' => 'id']);
    }

    public function getInterests()
    {
        return $this->hasMany(ProductsInterests::class, ['product_id' => 'id']);
    }

    public function getImage()
    {
        $imageModel = $this->hasOne(Images::class, ['product_id' => 'id'])->one();
        $imageLink = '/img/noimage.jpg';
        if (!empty($imageModel)) {
            $img = !empty($imageModel->imagecol)?$imageModel->imagecol:$imageModel->value;
            $imageLink = '/uploads/images/products/'.$img;
        }

        return $imageLink;
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Quarter]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuarter()
    {
        return $this->hasOne(Quarter::className(), ['id' => 'quarter_id']);
    }

    /**
     * Gets query for [[UnitsMeasure]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnitsMeasure()
    {
        return $this->hasOne(UnitsMeasure::className(), ['id' => 'units_measure_id']);
    }
    public function getNameCategory()
    {
        $category_id = $this->category_id;
        $Category = Category::find()->where(['id' => $category_id])->one();
        return $Category->name;
    }
    public static function getNameType($index = null) //Аксес статус
    {

        $arr= [
            self::TYPE_IMPORT => Yii::t('frontend', 'Импорт'),
            self::TYPE_ISSUED => Yii::t('frontend', 'Выпускаемая продукция'),
            self::TYPE_INMARKET => Yii::t('frontend', 'Местные закупки'),
            self::TYPE_SERVICES => Yii::t('frontend', 'Услуги'),
        ];
        return $index === null ? $arr : $arr[$index];
    }


    public static function productType() //Аксес статус
    {
        return [
            self::TYPE_IMPORT => Yii::t('frontend', 'Импорт'),
            self::TYPE_ISSUED => Yii::t('frontend', 'Выпускаемая продукция'),
            self::TYPE_INMARKET => Yii::t('frontend', 'Местные закупки'),
            self::TYPE_SERVICES => Yii::t('frontend', 'Услуги'),
        ];
    }

    public function getNameCompany()
    {
        $company_id = $this->company_id;
        $Company = Company::find()->where(['id' => $company_id])->one();
        return $Company->name;
    }
//    public function getNameUnitsMeasure()
//    {
//        $units_measure_id = $this->units_measure_id;
//        $UnitsMeasure = UnitsMeasure::find()->where(['id' => $units_measure_id])->one();
//        return $UnitsMeasure->name_uz;
//    }

    public function getNameQuarter()
    {
        $quarter_id = $this->quarter_id;
        $Quarter = Quarter::find()->where(['id' => $quarter_id])->one();
        return $Quarter->name;
    }
    public function getCompany()
    {
        $company = $this->hasOne(Company::class, ['id' => 'company_id'])->one();
        return $company->name;
    }

    public function getCompanyModel()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }
    public function getFeatures()
    {
        return $this->hasMany(ProductFeature::class, ['product_id' => 'id']);
    }
    public static function getCurrency($index = null)
    {
        $arr =  [
            self::CURRENCY_DOLLAR => Yii::t('frontend', 'Доллар'),
            self::CURRENCY_EVRO => Yii::t('frontend', 'Евро'),
            self::CURRENCY_RUBL => Yii::t('frontend', 'Рубль'),
            self::CURRENCY_SUM => Yii::t('frontend', 'Сум'),
        ];
        return $index === null ? $arr : $arr[$index];
    }
    public static function getNameCurrency($index = null)
    {
        $arr =  [
            0 => ' ',
            self::CURRENCY_DOLLAR => Yii::t('frontend', 'Доллар'),
            self::CURRENCY_EVRO => Yii::t('frontend', 'Евро'),
            self::CURRENCY_RUBL => Yii::t('frontend', 'Рубль'),
            self::CURRENCY_SUM => Yii::t('frontend', 'Сум'),
        ];
        return $arr[$index] != null ? $arr[$index] : " ";
    }
}
