<?php

namespace common\models\crm;

use common\models\User;
use Yii;

/**
 * This is the model class for table "crm_company_equipments_category".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int|null $type_id
 * @property string $created_at
 * @property int $created_by
 */
class CrmCompanyEquipmentsCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_company_equipments_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['created_by'], 'integer'],
            [['created_at', 'type_id'], 'safe'],
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
            'title' => Yii::t('crm', 'Title'),
            'description' => Yii::t('crm', 'Description'),
            'type_id' => Yii::t('crm', 'Type ID'),
            'created_at' => Yii::t('crm', 'Created At'),
            'created_by' => Yii::t('crm', 'Created By'),
        ];
    }
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->created_by = Yii::$app->user->id;
        }
        return parent::beforeSave($insert);
    }}
