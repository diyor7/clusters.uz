<?php

namespace common\models\organisation\umk;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
/**
 * This is the model class for table "product_feature".
 *
 * @property int $id
 * @property int $product_id
 * @property int $feature_id
 * @property string $value
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $uptadet_at
 *
 * @property Feature $feature
 * @property Product $product
 */
class ProductFeature extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'umk.product_feature';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'feature_id', 'value'], 'required'],
            [['product_id', 'feature_id', 'status'], 'integer'],
            [['created_at', 'uptadet_at'], 'safe'],
            [['value'], 'string', 'max' => 255],
            [['feature_id'], 'exist', 'skipOnError' => true, 'targetClass' => Feature::className(), 'targetAttribute' => ['feature_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'feature_id' => 'Feature ID',
            'value' => 'Value',
            'status' => 'Status',
            'created_at' => 'Created At',
            'uptadet_at' => 'Uptadet At',
        ];
    }

    /**
     * Gets query for [[Feature]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeature()
    {
        return $this->hasOne(Feature::className(), ['id' => 'feature_id']);
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
    public function getNameFeature()
    {
        $feature_id = $this->feature_id;
        $feature = Feature::find()->where(['id' => $feature_id])->one();
        return $feature->name;
    }
}
