<?php

namespace common\models\crm;

use common\models\User;
use Yii;

/**
 * This is the model class for table "crm_mine".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $capacity
 * @property int $unit_id
 * @property string $created_at
 * @property int $created_by
 * @property int $updated_by
 * @property string $updated_at
 * @property int $company_id
 */
class CrmMine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_mine';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'capacity', 'unit_id'], 'required'],
            [['capacity', 'unit_id', 'created_by', 'updated_by', 'company_id'], 'integer'],
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
            'title' => Yii::t('crm', 'Title'),
            'description' => Yii::t('crm', 'Description'),
            'capacity' => Yii::t('crm', 'Capacity'),
            'unit_id' => Yii::t('crm', 'Unit ID'),
            'created_at' => Yii::t('crm', 'Created At'),
            'created_by' => Yii::t('crm', 'Created By'),
            'updated_by' => Yii::t('crm', 'Updated By'),
            'updated_at' => Yii::t('crm', 'Updated At'),
            'company_id' => Yii::t('crm', 'Company ID'),
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
