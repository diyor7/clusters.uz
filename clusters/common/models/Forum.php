<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bank".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $who_is
 * @property string $email
 * @property string $occupation
 * @property string $country
 * @property string $organization
 * @property string $phone
 * @property string $panel
 * @property string $theme
 * @property string $created_at
 *
 * @property CompanyBankAccount[] $companyBankAccounts
 */
class Forum extends \yii\db\ActiveRecord
{
    const LISTENER = 1;
    const SPEAKER = 2;

    public static function getTypeWhoIs($index=null){
        $arr = [
            self::LISTENER => t("Слушатель"),
            self::SPEAKER => t("Диктор"),
        ];
        return $index === null ? $arr : $arr[$index];
    }
    public static function getPanels($index=null){
        $arr = [
            self::LISTENER => t("Panel 1"),
            self::SPEAKER => t("Panel 2"),
        ];
        return $index === null ? $arr : $arr[$index];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forum';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'who_is', 'panel', 'organization',  'last_name', 'email', 'occupation', 'country'], 'required'],
            [['first_name', 'who_is',  'panel', 'organization', 'phone', 'theme', 'last_name', 'email', 'occupation', 'country', 'created_at'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'first_name' => t('Имя'),
            'last_name' => t('Фамилия'),
            'email' => t('Эл. адрес'),
            'occupation' => t('Занятие'),
            'country' => t('Страна'),
            'organization' => t('Организация'),
            'phone' => t('Номер телефона'),
            'panel' => t('Панел'),
            'theme' => t('Тема'),
            'who_is' => t(''),
        ];
    }

}
