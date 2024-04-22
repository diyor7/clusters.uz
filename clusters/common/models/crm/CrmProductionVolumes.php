<?php

namespace common\models\crm;

use common\models\User;
use Yii;

/**
 * This is the model class for table "crm_production_volumes".
 *
 * @property int $id
 * @property int $date
 * @property int $product_id
 * @property int $unit_id
 * @property int $stock_volume
 * @property int $defective_volume
 * @property int $next_volume
 * @property int $company_id
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int|null $updated_by
 */
class CrmProductionVolumes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_production_volumes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'product_id', 'unit_id', 'stock_volume', 'defective_volume', 'next_volume'], 'required'],
            [['product_id', 'unit_id', 'stock_volume', 'defective_volume', 'next_volume', 'company_id', 'created_by', 'updated_by'], 'integer'],
            [['date'], 'string', 'max' => 50],
            [['created_at', 'updated_at'], 'safe'],
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
            'product_id' => Yii::t('crm', 'Product ID'),
            'unit_id' => Yii::t('crm', 'Unit ID'),
            'stock_volume' => Yii::t('crm', 'Stock Volume'),
            'defective_volume' => Yii::t('crm', 'Defective Volume'),
            'next_volume' => Yii::t('crm', 'Next Volume'),
            'company_id' => Yii::t('crm', 'Company ID'),
            'created_at' => Yii::t('crm', 'Created At'),
            'created_by' => Yii::t('crm', 'Created By'),
            'updated_at' => Yii::t('crm', 'Updated At'),
            'updated_by' => Yii::t('crm', 'Updated By'),
        ];
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
