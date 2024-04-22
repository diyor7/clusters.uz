<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $full_name
 * @property string $last
 * @property string $description
 * @property string $address
 * @property string $phone
 * @property string $cert_reg_date
 * @property string $cert_expiry_date
 * @property string $cert_num
 * @property string $activity_type
 * @property string $additional_activities
 * @property string $cert_url
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required', 'on' => "register"],
            [['full_name'], 'required'],
            [['user_id'], 'integer'],
            [['description', 'address'], 'string'],

            [[
                'cert_num',
                'activity_type',
                'additional_activities',
                'cert_url'
            ], 'string', 'max' => 255],

            [[
                'cert_reg_date',
                'cert_expiry_date',
            ], 'safe'],

            [['full_name'], 'string', 'min' => 2, 'max' => 50],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'full_name' => 'Full name',
            'address' => 'Address',
            'description' => 'Description'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
