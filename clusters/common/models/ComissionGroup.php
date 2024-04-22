<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comission_group".
 *
 * @property int $id
 * @property int $commission_id
 * @property string $role
 */
class ComissionGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comission_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['commission_id', 'role'], 'required'],
            [['commission_id'], 'integer'],
            [['role'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'commission_id' => Yii::t('main', 'Commission ID'),
            'role' => Yii::t('main', 'Role'),
        ];
    }
}
