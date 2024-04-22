<?php

namespace common\models\crm;

use common\models\Category;
use common\models\UnitTranslate;
use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "crm_product".
 *
 * @property int $id
 * @property int|null $code
 * @property int $category_id
 * @property int $type_id
 * @property string $title
 * @property string|null $description
 * @property int $company_id
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int|null $updated_by
 */
class CrmProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'type_id'], 'integer'],
            [['category_id', 'type_id', 'title'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('crm', 'ID'),
            'code' => Yii::t('crm', 'Code'),
            'category_id' => Yii::t('crm', 'Category ID'),
            'type_id' => Yii::t('crm', 'Type ID'),
            'title' => Yii::t('crm', 'Title'),
            'description' => Yii::t('crm', 'Description'),
            'company_id' => Yii::t('crm', 'Company ID'),
            'created_at' => Yii::t('crm', 'Created At'),
            'created_by' => Yii::t('crm', 'Created By'),
            'updated_at' => Yii::t('crm', 'Updated At'),
            'updated_by' => Yii::t('crm', 'Updated By'),
        ];
    }

    public static function getUnits() {
        $units = UnitTranslate::find()->select('unit_id, title')->asArray()->all();
        return ArrayHelper::map($units, 'unit_id', 'title');
    }

    public static function getMines() {
        $mines = CrmMine::find()->select('id, title')->asArray()->all();
        return ArrayHelper::map($mines, 'id', 'title');
    }

    public static function getProducts() {
        $products = CrmProduct::find()->select('id, title')->asArray()->all();
        return ArrayHelper::map($products, 'id', 'title');
    }

    public static function getProductTitle($id) {
        $product = !empty(CrmProduct::findOne($id))?CrmProduct::findOne($id)->title:'Не определено';
        return $product;
    }

    public static function getUnitTitle($unit_id) {
        $unit = !empty(UnitTranslate::findOne(['unit_id' => $unit_id]))?UnitTranslate::findOne(['unit_id' => $unit_id])->title:'Не определено';
        return $unit;
    }

    public function getCategoryTitle() {
        $title = !empty(Category::findOne($this->category_id))?Category::findOne($this->category_id)->title:'Не определено';
        return $title;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public static function getCurrentUserName()
    {
        $CurrentUser = User::findOne(Yii::$app->user->id);
        return empty($CurrentUser)?'Не определено':$CurrentUser->username;
    }

    public static function getCreatedUserName($created_user_id)
    {
        $user = User::findOne($created_user_id);
        return empty($user)?'Не определено':$user->username;
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->created_by = Yii::$app->user->id;
        }else {
            $this->updated_by = Yii::$app->user->id;
        }
        $user = User::findOne(Yii::$app->user->id);
        $this->company_id = empty($user)?:$user->company_id;
        return parent::beforeSave($insert);
    }
}
