<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_translate".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $lang
 * @property string $title
 * @property string $description
 * @property string $usage
 * @property string $properties
 * @property string $metakeywords
 * @property string $metadescription
 * @property string $metatitle
 *
 * @property Product $product
 */
class ProductTranslate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_translate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'lang', 'title'], 'required'],
            [['product_id', 'lang'], 'integer'],
            [['description', 'usage', 'properties', 'metadescription'], 'string'],
            [['title', 'metakeywords', 'metatitle'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'lang' => 'Lang',
            'title' => 'Title',
            'description' => 'Description',
            'usage' => 'Usage',
            'properties' => 'Properties',
            'metakeywords' => 'Metakeywords',
            'metadescription' => 'Metadescription',
            'metatitle' => 'Metatitle',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

}
