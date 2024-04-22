<?php

namespace common\models\crm;

use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "crm_mining".
 *
 * @property int $id
 * @property string $date
 * @property int $type mine|reproduce
 * @property int $size
 * @property int $product_id
 * @property int $capacity hajmi
 * @property int $unit_id birligi
 * @property int $mine_id Kon idsi
 * @property int $capacity_next keyingi oyga hajm
 * @property int $capacity_next_unit_id keyingi oyga hajm birligi
 * @property string $updated_at
 * @property int|null $updated_by
 * @property string $created_at
 * @property int $created_by
 * @property int $company_id
 */
class CrmMining extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_mining';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'type', 'product_id', 'capacity', 'unit_id', 'mine_id', 'capacity_next', 'capacity_next_unit_id'], 'required'],
            [['type', 'size', 'product_id', 'capacity', 'unit_id', 'mine_id', 'capacity_next', 'capacity_next_unit_id', 'updated_by', 'created_by', 'company_id'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
            [['date'], 'string', 'max' => 50],
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
            'size' => Yii::t('crm', 'Size'),
            'product_id' => Yii::t('crm', 'Product ID'),
            'capacity' => Yii::t('crm', 'Capacity'),
            'unit_id' => Yii::t('crm', 'Unit ID'),
            'mine_id' => Yii::t('crm', 'Mine ID'),
            'capacity_next' => Yii::t('crm', 'Capacity Next'),
            'capacity_next_unit_id' => Yii::t('crm', 'Capacity Next Unit ID'),
            'updated_at' => Yii::t('crm', 'Updated At'),
            'updated_by' => Yii::t('crm', 'Updated By'),
            'created_at' => Yii::t('crm', 'Created At'),
            'created_by' => Yii::t('crm', 'Created By'),
            'company_id' => Yii::t('crm', 'Company ID'),
        ];
    }


    public static function getMines() {
        $mines = CrmMine::find()->select('id, title')->asArray()->all();
        return ArrayHelper::map($mines, 'id', 'title');
    }

    public static function getMineTitle($id) {
        $mine = !empty(CrmMine::findOne($id))?CrmMine::findOne($id)->title:'Не определено';
        return $mine;
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
