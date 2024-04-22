<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "classifier_category".
 *
 * @property int $id
 * @property string|null $name_uz
 * @property string|null $name_oz
 * @property string|null $name_ru
 * @property string|null $name_en
 * @property string|null $code
 * @property int|null $parent_id
 * @property int|null $level
 */
class ClassifierCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'classifier_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'parent_id', 'level'], 'integer'],
            [['name_uz', 'name_oz', 'name_ru', 'name_en'], 'string', 'max' => 512],
            [['code'], 'string', 'max' => 255],
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
            'name_uz' => 'Name Uz',
            'name_oz' => 'Name Oz',
            'name_ru' => 'Name Ru',
            'name_en' => 'Name En',
            'code' => 'Code',
            'parent_id' => 'Parent ID',
            'level' => 'Level',
        ];
    }
}
