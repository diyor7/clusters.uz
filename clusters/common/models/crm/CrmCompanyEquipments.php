<?php

namespace common\models\crm;

use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "crm_company_equipments".
 *
 * @property int $id
 * @property int|null $code
 * @property int $category_id
 * @property int $type_id
 * @property string $title
 * @property string|null $description
 * @property string $parametres
 * @property int $equipment_count
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int|null $updated_by
 * @property int $company_id
 */
class CrmCompanyEquipments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_company_equipments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'type_id', 'equipment_count'], 'integer'],
            [['category_id', 'title', 'parametres', 'equipment_count'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['description', 'parametres'], 'string', 'max' => 500],
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
            'parametres' => Yii::t('crm', 'Parametres'),
            'equipment_count' => Yii::t('crm', 'Equipment Count'),
            'created_at' => Yii::t('crm', 'Created At'),
            'created_by' => Yii::t('crm', 'Created By'),
            'updated_at' => Yii::t('crm', 'Updated At'),
            'updated_by' => Yii::t('crm', 'Updated By'),
            'company_id' => Yii::t('crm', 'Company ID'),
        ];
    }

    public static function getCategories() {
        $categories = CrmCompanyEquipmentsCategory::find()->select('id, title')->asArray()->all();
        return ArrayHelper::map($categories, 'id', 'title');
    }

    public function getCategoryTitle() {
        $category = !empty(CrmCompanyEquipmentsCategory::findOne($this->category_id))?CrmCompanyEquipmentsCategory::findOne($this->category_id)->title:'Не определено';
        return $category;
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->created_by = Yii::$app->user->id;
        }else {
            $this->updated_by = Yii::$app->user->id;
        }
        $this->company_id = User::findOne(Yii::$app->user->id)->company_id;
        return parent::beforeSave($insert);
    }
}
