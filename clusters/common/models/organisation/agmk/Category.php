<?php

namespace common\models\organisation\agmk;

use phpDocumentor\Reflection\Types\This;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property string|null $image
 * @property int $company_id
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Product[] $products
 */
class Category extends \yii\db\ActiveRecord
{
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
    public $file;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const TYPE_SERVICES = 3;

    const TYPE_IMPORT = 0;
    const TYPE_ISSUED = 1;
    const TYPE_INMARKET = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agmk.category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'company_id'], 'required'],
            [['company_id','type'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name','imagecol'], 'string', 'max' => 255],
            [['image', 'status'], 'string', 'max' => 45],
            ['file', 'file', 'extensions' => 'jpg, jpeg, png', 'skipOnEmpty' => true,'maxSize' => 1024 * 1024 * 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'image' => 'Изображение',
            'company_id' => 'Компания',
            'status' => 'Статус',
            'type' => 'Tип',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */

    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

    public function getProductsByCompanyOld($company_id)
    {
        $company = Company::findOne($company_id);
        $companies = Company::find()->select('id')->where(['status' => 1, 'parent_id' => $company->id])->orWhere(['id' => $company->id])->groupBy('id');

        return $this->hasMany(Product::class, ['category_id' => 'id'])->andWhere(['in','company_id',$companies, 'status' => 1]);
    }

    public function getProductsByCompany($company_id)
    {
        return $this->hasMany(Product::class, ['category_id' => 'id'])->andWhere(['company_id' => $company_id, 'status' => 1]);
    }

    public function getProductsByType($type)
    {
        return $this->hasMany(Product::class, ['category_id' => 'id'])->andWhere(['type' => $type, 'status' => 1]);
    }

    public function getProductsByCompanyByType($company_id, $type, $is_main_company = false)
    {
        if($is_main_company) {
            $companies = Company::find()->select('id')->where(['parent_id' => $company_id]);
            return $this->hasMany(Product::class, ['category_id' => 'id'])->andWhere(['type' => $type, 'status' => 1])->andWhere(['in', 'company_id' , $companies]);
        }else {
            return $this->hasMany(Product::class, ['category_id' => 'id'])->andWhere(['type' => $type, 'company_id' => $company_id, 'status' => 1]);
        }
    }

    public static function categoryStatus() //Аксес статус
    {
        return [
            self::STATUS_ACTIVE => 'Актив',
            self::STATUS_INACTIVE => 'Не актив',
        ];
    }

    public static function getNameStatus($index = null) //Аксес статус
    {
        $arr= [
            self::TYPE_IMPORT => Yii::t('frontend', 'Импорт'),
            self::TYPE_ISSUED => Yii::t('frontend', 'Выпускаемая продукция'),
            self::TYPE_INMARKET => Yii::t('frontend', 'Местные закупки'),
            self::TYPE_SERVICES => Yii::t('frontend', 'Услуги'),
        ];
        return $index === null ? $arr : $arr[$index];
    }

    public static function categoryType() //Аксес статус
    {
        return [
            self::TYPE_IMPORT => 'Импорт',
            self::TYPE_ISSUED => 'Выпускаемая продукция',
            self::TYPE_INMARKET => 'Местные закупки',
            self::TYPE_SERVICES => Yii::t('frontend', 'Услуги'),
        ];
    }

    public function getType($type_id) //Аксес статус
    {
        $type = [
            self::TYPE_IMPORT => Yii::t('frontend', 'Импорт'),
            self::TYPE_ISSUED => Yii::t('frontend', 'Выпускаемая продукция'),
            self::TYPE_INMARKET => Yii::t('frontend', 'Местные закупки'),
            self::TYPE_SERVICES => Yii::t('frontend', 'Услуги'),
        ];

        return $type[$type_id];
    }

    public function getNameCompany()
    {
        $company_id = $this->company_id;
        $company = Company::find()->where(['id' => $company_id])->one();
        if($company){
            return $company->name;
        }
    }

    public function getParent() {
        return $this->hasOne(Company::class, ['parent_id' => 'id']);
    }
}
