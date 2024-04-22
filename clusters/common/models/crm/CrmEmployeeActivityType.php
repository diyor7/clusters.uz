<?php

namespace common\models\crm;

use Yii;

/**
 * This is the model class for table "crm_employee_activity_type".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int|null $company_id
 */
class CrmEmployeeActivityType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_employee_activity_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['company_id'], 'integer'],
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
            'company_id' => Yii::t('crm', 'Company ID'),
        ];
    }
}
