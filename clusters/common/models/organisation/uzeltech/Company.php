<?php

namespace common\models\organisation\uzeltech;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;


/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent_id
 * @property string|null $logo
 * @property string|null $information
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $director_full_name
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $image1
 * @property string|null $image2
 * @property string|null $image3
 */
class Company extends \yii\db\ActiveRecord
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

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    public $file;
    public $file1;
    public $file2;
    public $file3;
    public $panorama;
    public $full_name = 'Ассоциация «Узэлтехсаноат»';
    public $folder = 'uzeltech';
    public $logo = '/organisations/uzeltech/src/img/logo_navbar.png';
    public $link = 'http://uzeltech.cooperation.uz';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'uzeltech_company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id', 'status'], 'integer'],
            [['information'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'address', 'cord','panorama'], 'string', 'max' => 255],
            [['logo', 'phone', 'email', 'director_full_name'], 'string', 'max' => 45],
            [['image1', 'image2', 'image3'], 'string', 'max' => 50],
            [['file'], 'file', 'extensions' => 'jpg, jpeg, png', 'skipOnEmpty' => true,'maxSize' => 1024 * 1024 * 5],
            ['file1', 'file', 'extensions' => 'jpg, jpeg, png', 'skipOnEmpty' => true,'maxSize' => 1024 * 1024 * 5],
            ['file2', 'file', 'extensions' => 'jpg, jpeg, png', 'skipOnEmpty' => true,'maxSize' => 1024 * 1024 * 5],
            ['file3', 'file', 'extensions' => 'jpg, jpeg, png', 'skipOnEmpty' => true,'maxSize' => 1024 * 1024 * 5],
            ['panorama', 'file', 'extensions' => 'jpg, jpeg, png', 'skipOnEmpty' => true,'maxSize' => 1024 * 1024 * 5],
            ['file', 'required', 'on' => 'create'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('frontend', 'Название'),
            'parent_id' => Yii::t('frontend','Pодитель ID'),
            'logo' => Yii::t('frontend','Логотип'),
            'information' => Yii::t('frontend','Информация'),
            'address' => Yii::t('frontend','Aдрес'),
            'phone' => Yii::t('frontend','Телефон'),
            'email' => Yii::t('frontend','Email'),
            'cord' => Yii::t('frontend','Kоордината компанию'),
            'director_full_name' => Yii::t('frontend','Директор Полное имя'),
            'status' => Yii::t('frontend','Status'),
            'created_at' => Yii::t('frontend','Created At'),
            'updated_at' => Yii::t('frontend','Updated At'),
        ];
    }
    public static function copmanyStatus() //Аксес статус
    {
        return [
            self::STATUS_ACTIVE => 'Актив',
            self::STATUS_INACTIVE => 'Не актив',
        ];
    }

    public function getCompany()
    {
        $parent_id = $this->parent_id;
        $company = Company::find()->where(['id' => $parent_id])->one();
        if($company){
            return $company->name;
        }
    }

    public function getParent() {
        return $this->hasOne(Company::class, ['id' => 'parent_id'])->andWhere(['status' => 1]);
    }

    public function getProducts() {
        return $this->hasMany(Product::class, ['company_id' => 'id'])->andWhere(['status' => 1]);
    }

    public function getProductsByType($type) {
        return $this->hasMany(Product::class, ['company_id' => 'id'])->andWhere(['type' => $type, 'status' => 1]);
    }

    public function getProductsByTypeByCategory($type, $category_id) {
        return $this->hasMany(Product::class, ['company_id' => 'id'])->andWhere(['type' => $type, 'category_id' => $category_id, 'status' => 1]);
    }

    public function getChildren() {
        return $this->hasMany(Company::class, ['parent_id' => 'id'])->andWhere(['status' => 1]);
    }

    public function getCategories() {
        if (!empty($this->parent_id)) {
            return $this->hasMany(Category::class, ['company_id' => 'parent_id'])->andWhere(['status' => 1]);
        }else {
            return $this->hasMany(Category::class, ['company_id' => 'id'])->andWhere(['status' => 1]);
        }
    }
    public function getNameType($index)
    {
        return Product::getNameType($index);
    }
}
