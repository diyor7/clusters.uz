<?php

namespace common\models\crm;

use common\models\Unit;
use common\models\UnitTranslate;
use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "crm_cargo_volumes".
 *
 * @property int $id
 * @property int $date
 * @property int $product_id
 * @property int $unit_id
 * @property int $size_loaded
 * @property int $size_delivered
 * @property int $size_remaining
 * @property int $company_id
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int|null $updated_by
 */
class CrmCargoVolumes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_cargo_volumes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'product_id', 'unit_id', 'size_loaded', 'size_delivered', 'size_remaining'], 'required'],
            [['product_id', 'unit_id', 'size_loaded', 'size_delivered', 'size_remaining', 'company_id', 'created_by', 'updated_by'], 'integer'],
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
            'size_loaded' => Yii::t('crm', 'Size Loaded'),
            'size_delivered' => Yii::t('crm', 'Size Delivered'),
            'size_remaining' => Yii::t('crm', 'Size Remaining'),
            'company_id' => Yii::t('crm', 'Company ID'),
            'created_at' => Yii::t('crm', 'Created At'),
            'created_by' => Yii::t('crm', 'Created By'),
            'updated_at' => Yii::t('crm', 'Updated At'),
            'updated_by' => Yii::t('crm', 'Updated By'),
        ];
    }

    public static function getUnits() {
        $units = User::find()->select('unit_id, title')->asArray()->all();
        return ArrayHelper::map($units, 'unit_id', 'title');
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
