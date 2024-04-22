<?php

namespace common\models\crm;

use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "crm_workers_employed".
 *
 * @property int $id
 * @property int $type
 * @property string $date
 * @property int $title
 * @property int $count
 * @property int $workertype_id
 * @property string $lifetime
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int|null $updated_by
 * @property int $company_id
 */
class CrmWorkersEmployed extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_workers_employed';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'count', 'workertype_id', 'lifetime'], 'required'],
            [['type', 'count', 'workertype_id', 'created_by', 'updated_by', 'company_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['date', 'lifetime'], 'string', 'max' => 50],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('crm', 'ID'),
            'type' => Yii::t('crm', 'Type'),
            'date' => Yii::t('crm', 'Date'),
            'title' => Yii::t('crm', 'Title'),
            'count' => Yii::t('crm', 'Count'),
            'workertype_id' => Yii::t('crm', 'Workertype ID'),
            'lifetime' => Yii::t('crm', 'Lifetime'),
            'created_at' => Yii::t('crm', 'Created At'),
            'created_by' => Yii::t('crm', 'Created By'),
            'updated_at' => Yii::t('crm', 'Updated At'),
            'updated_by' => Yii::t('crm', 'Updated By'),
            'company_id' => Yii::t('crm', 'Company ID'),
        ];
    }

    public static function getEmployeeActivityTypes() {
        $eat = CrmEmployeeActivityType::find()->select('id, title')->asArray()->all();
        return ArrayHelper::map($eat, 'id', 'title');
    }

    public function getEmployeeActivityTypeTitle() {
        $eat = CrmEmployeeActivityType::findOne($this->workertype_id);
        return !empty($eat)?$eat->title:'Не определено';
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
