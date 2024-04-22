<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $name
 * @property double $latitude
 * @property double $longitude
 * @property string $created_at
 * @property integer $user_id
 * @property string $text
 *
 * @property User $user
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'latitude', 'longitude', 'user_id'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['created_at'], 'safe'],
            [['user_id'], 'integer'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 255],
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
            'name' => t("Название"),
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'created_at' => 'Created At',
            'user_id' => t("Пользователь"),
            'text' => t("Адрес"),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        if (!$this->text) {
            try {
                $context = stream_context_create(
                    [
                        "http" => [
                            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
                        ]
                    ]
                );
                $json = file_get_contents("https://nominatim.openstreetmap.org/reverse?lat=$this->latitude&lon=$this->longitude&format=json&accept-language=" . Yii::$app->language, false, $context);

                $this->text = json_decode($json)->display_name;
            } catch (\Exception $e) { }
        }
        return parent::beforeSave($insert);
    }
}
