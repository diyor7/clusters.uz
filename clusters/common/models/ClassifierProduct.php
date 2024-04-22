<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "classifier_product".
 *
 * @property int $id
 * @property int|null $category_id
 * @property string|null $code
 * @property string|null $name_uz
 * @property string|null $name_oz
 * @property string|null $name_ru
 * @property string|null $name_en
 * @property string|null $measurement_unit
 * @property string|null $measurement_unit_short
 * @property int|null $disabled
 * @property string|null $product_code
 * @property int|null $cert_required
 * @property string|null $measure_unit
 * @property string|null $measure_unit_short
 * @property string|null $soogu_id
 */
class ClassifierProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'classifier_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'category_id', 'disabled', 'cert_required'], 'integer'],
            [['code'], 'string', 'max' => 25],
            [['name_uz', 'name_oz', 'name_ru', 'name_en'], 'string', 'max' => 500],
            [['measurement_unit'], 'string', 'max' => 50],
            [['measurement_unit_short'], 'string', 'max' => 20],
            [['product_code', 'measure_unit', 'measure_unit_short'], 'string', 'max' => 255],
            [['soogu_id'], 'string', 'max' => 10],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'code' => 'Code',
            'name_uz' => 'Name Uz',
            'name_oz' => 'Name Oz',
            'name_ru' => 'Name Ru',
            'name_en' => 'Name En',
            'measurement_unit' => 'Measurement Unit',
            'measurement_unit_short' => 'Measurement Unit Short',
            'disabled' => 'Disabled',
            'product_code' => 'Product Code',
            'cert_required' => 'Cert Required',
            'measure_unit' => 'Measure Unit',
            'measure_unit_short' => 'Measure Unit Short',
            'soogu_id' => 'Soogu ID',
        ];
    }
}
