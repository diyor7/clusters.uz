<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bank".
 *
 * @property integer $id
 * @property string $mfo
 * @property integer $mark
 * @property string $brand_name
 * @property string $name
 * @property string $address
 * @property string $created_at
 * @property string $updated_at
 * @property string $region
 * @property string $city
 * @property string $district
 * @property string $tin
 * @property string $web_site
 *
 * @property CompanyBankAccount[] $companyBankAccounts
 */
class Bank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bank';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'mark'], 'integer'],
            [['address'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['mfo'], 'string', 'max' => 10],
            [['brand_name', 'name'], 'string', 'max' => 255],
            [['region', 'city'], 'string', 'max' => 50],
            [['district'], 'string', 'max' => 100],
            [['tin'], 'string', 'max' => 15],
            [['web_site'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mfo' => 'Mfo',
            'mark' => 'Mark',
            'brand_name' => 'Brand Name',
            'name' => 'Name',
            'address' => 'Address',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'region' => 'Region',
            'city' => 'City',
            'district' => 'District',
            'tin' => 'Tin',
            'web_site' => 'Web Site',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyBankAccounts()
    {
        return $this->hasMany(CompanyBankAccount::className(), ['mfo' => 'mfo']);
    }
}
