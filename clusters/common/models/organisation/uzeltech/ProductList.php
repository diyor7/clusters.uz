<?php

namespace common\models\organisation\uzeltech;

use Yii;

/**
 * This is the model class for table "product_list".
 *
 * @property int $id
 * @property int $company_id
 * @property int $category_id
 * @property string $description
 * @property int|null $status
 */
class ProductList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'uzeltech.product_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'category_id', 'description'], 'required'],
            [['company_id', 'category_id', 'status','type'], 'integer'],
            [['description'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'category_id' => 'Категория',
            'price' => 'Цена',
            'code' => 'ТИФ ТН коди',
            'views' => 'Views',
            'company_id' => 'Компания',
            'need_year' => 'Производственная мощность в год',
            'feature_id' => 'Характер ID',
            'units_measure_id' => 'Единицы измерения ID',
            'quarter_id' => 'Квартал ID',
            'description' => 'Описание',
            'status' => 'Status',
            'currency' => 'Валюта',
            'year' => 'Год последний закупки',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getNameCompany()
    {
        $company_id = $this->company_id;
        $Company = Company::find()->where(['id' => $company_id])->one();
        return $Company->name;
    }
    public function getNameCategory()
    {
        $category_id = $this->category_id;
        $Category = Category::find()->where(['id' => $category_id])->one();
        return $Category->name;
    }
}
