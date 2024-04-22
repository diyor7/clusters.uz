<?php

namespace common\models\crm;

use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "crm_equipments_used".
 *
 * @property int $id
 * @property string $date
 * @property int $type mine|reproduce
 * @property int $equipment_id
 * @property int $count
 * @property string $lifetime ishlagan soati
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int|null $updated_by
 * @property int $company_id
 */
class CrmEquipmentsUsed extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_equipments_used';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'type', 'equipment_id', 'count', 'lifetime'], 'required'],
            [['type', 'equipment_id', 'count', 'created_by', 'updated_by', 'company_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['date', 'lifetime'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('crm', 'ID'),
            'date' => Yii::t('crm', 'Date'),
            'type' => Yii::t('crm', 'Type'),
            'equipment_id' => Yii::t('crm', 'Equipment ID'),
            'count' => Yii::t('crm', 'Count'),
            'lifetime' => Yii::t('crm', 'Lifetime'),
            'created_at' => Yii::t('crm', 'Created At'),
            'created_by' => Yii::t('crm', 'Created By'),
            'updated_at' => Yii::t('crm', 'Updated At'),
            'updated_by' => Yii::t('crm', 'Updated By'),
            'company_id' => Yii::t('crm', 'Company ID'),
        ];
    }


    public static function getEquipments() {
        $equipments = CrmCompanyEquipments::find()->select('id, title')->asArray()->all();
        return ArrayHelper::map($equipments, 'id', 'title');
    }

    public function getEquipmentTitle() {
        $equipment = CrmCompanyEquipments::findOne($this->equipment_id);
        return !empty($equipment)?$equipment->title:'Не определено';
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
