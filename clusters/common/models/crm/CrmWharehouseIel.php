<?php

namespace common\models\crm;

use common\models\User;
use Yii;

/**
 * This is the model class for table "crm_wharehouse_iel".
 *
 * @property int $id
 * @property int $prduct_type_id good|product
 * @property int $product_id
 * @property int $product_unit_id
 * @property int $balance_from
 * @property int $balance_out
 * @property int $balance_in
 * @property int $balance_left
 * @property int $company_id
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int|null $updated_by
 */
class CrmWharehouseIel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_wharehouse_iel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prduct_type_id', 'product_id', 'product_unit_id', 'balance_from', 'balance_out', 'balance_in', 'balance_left'], 'required'],
            [['prduct_type_id', 'product_id', 'product_unit_id', 'balance_from', 'balance_out', 'balance_in', 'balance_left', 'company_id', 'created_by', 'updated_by'], 'integer'],
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
            'prduct_type_id' => Yii::t('crm', 'Prduct Type ID'),
            'product_id' => Yii::t('crm', 'Product ID'),
            'product_unit_id' => Yii::t('crm', 'Product Unit ID'),
            'balance_from' => Yii::t('crm', 'Balance From'),
            'balance_out' => Yii::t('crm', 'Balance Out'),
            'balance_in' => Yii::t('crm', 'Balance In'),
            'balance_left' => Yii::t('crm', 'Balance Left'),
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
