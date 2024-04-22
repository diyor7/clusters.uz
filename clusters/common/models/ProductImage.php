<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_image".
 *
 * @property integer $id
 * @property string $filename
 * @property integer $product_id
 *
 * @property Product $product
 */
class ProductImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filename', 'product_id'], 'required'],
            [['product_id'], 'integer'],
            [['filename'], 'string', 'max' => 255],
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
            'filename' => 'Filename',
            'product_id' => 'Product ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
    
    public function getPath()
    {
        $extension = pathinfo($this->filename, PATHINFO_EXTENSION);

        if (Yii::getAlias("@uploads") . '/product/webp/' . str_replace($extension, 'webp', $this->filename)) {
            return siteUrl() . "uploads/product/webp/" . str_replace($extension, 'webp', $this->filename);
        }
        
        return siteUrl() . "uploads/product/webp/" . $this->filename;
    }

    public function getOriginalPath()
    {
        return siteUrl() . "uploads/product/" . $this->filename;
    }
}
