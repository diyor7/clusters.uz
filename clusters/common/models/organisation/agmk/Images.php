<?php

namespace common\models\organisation\agmk;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string|null $value
 * @property int $product_id
 * @property string|null $imagecol
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Product $product
 */
class Images extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    public $imageFiles = [];
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'agmk.image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['product_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['value', 'imagecol'], 'string', 'max' => 45],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            ['file', 'file', 'extensions' => 'jpg, jpeg, png', 'skipOnEmpty' => true,'maxSize' => 1024 * 1024 * 5],
            [['imageFiles'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 10],
            [['imageFiles'], 'required'],
            [['file'], 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'product_id' => 'Product ID',
            'imagecol' => 'Imagecol',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',

        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
