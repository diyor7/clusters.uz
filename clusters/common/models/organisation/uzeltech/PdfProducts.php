<?php

namespace common\models\organisation\uzeltech;

use Yii;

/**
 * This is the model class for table "pdf_products".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string $link
 * @property string $img
 * @property int $created_by
 * @property int $section
 * @property string $created_at
 * @property int $updated_by
 * @property string $updated_at
 */
class PdfProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'uzeltech.pdf_products';
    }
    public $file;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['link', 'img', 'created_by', 'updated_by', 'updated_at'], 'required'],
            [['created_by', 'updated_by', 'section'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'link', 'img'], 'string', 'max' => 255],
            ['file', 'file', 'extensions' => 'pdf', 'skipOnEmpty' => true,'maxSize' => 1024 * 1024 * 100],
            [['description'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'title' => Yii::t('frontend', 'Title'),
            'description' => Yii::t('frontend', 'Description'),
            'link' => Yii::t('frontend', 'PDF продукты'),
            'file' => Yii::t('frontend', 'PDF продукты'),
            'img' => Yii::t('frontend', 'Img'),
            'section' => Yii::t('frontend', 'Section'),
            'created_by' => Yii::t('frontend', 'Created By'),
            'created_at' => Yii::t('frontend', 'Created At'),
            'updated_by' => Yii::t('frontend', 'Updated By'),
            'updated_at' => Yii::t('frontend', 'Updated At'),
        ];
    }

    public static function getSection($index = null) //Аксес статус
    {
        $arr= [
            1 => Yii::t('frontend', 'ПРОИЗВОДСТВО КАБЕЛЬНО-ПРОВОДНИКОВОЙ ПРОДУКЦИИ'),
            2 => Yii::t('frontend', 'ПРОИЗВОДСТВО ЭЛЕКТРОБЫТОВОЙ ПРОДУКЦИИ'),
            3 => Yii::t('frontend', 'ПРОИЗВОДСТВО ЭЛЕКТРОСИЛОВОГО ОБОРУДОВАНИЯ'),
        ];
        return $index === null ? $arr : $arr[$index];
    }

}
