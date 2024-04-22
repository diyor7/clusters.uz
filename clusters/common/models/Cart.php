<?php

namespace common\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "cart".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $product_id
 * @property integer $quantity
 * @property string $sess_id
 *
 * @property Product $product
 */
class Cart extends \yii\db\ActiveRecord
{
    public static function getUserCartData()
    {
        $cart = self::find();

        if (Yii::$app->user->id) {
            $cart->where(['cart.user_id' => Yii::$app->user->id]);
        } else {
            $cart->where(['cart.sess_id' => Yii::$app->session->id]);
        }

        $quantity = $cart->sum("cart.quantity") + 0;
        $total_sum = $cart->joinWith('product')->sum(new Expression("cart.quantity * product.price")) + 0;
        $total_sum_old = $cart->sum(new Expression("cart.quantity * ifnull(product.price_old, product.price)")) + 0;
        $total_sale = $cart->sum(new Expression("cart.quantity * ifnull(product.price_old, product.price) - cart.quantity * product.price")) + 0;

        $deposit_percentage = isset(Yii::$app->params['deposit_percentage']) ? Yii::$app->params['deposit_percentage'] : 3;
        $commission_percentage = isset(Yii::$app->params['commission_percentage']) ? Yii::$app->params['commission_percentage'] : 0.15;

        $block_percentage = $deposit_percentage + $commission_percentage;

        return [
            'quantity' =>  $quantity,
            'total_sum' => $total_sum,
            'total_sum_formatted' => showPrice($total_sum),
            'deposit_sum' => $total_sum * $deposit_percentage / 100,
            'deposit_sum_formatted' => showPrice($total_sum * $deposit_percentage / 100),
            'commission_sum' => $total_sum * $commission_percentage / 100,
            'commission_sum_formatted' => showPrice($total_sum * $commission_percentage / 100),
            'total_block_sum' => $total_sum * $block_percentage / 100,
            'total_block_sum_formatted' => showPrice($total_sum * $block_percentage / 100),
            'total_sum_old' => $total_sum_old,
            'total_sum_old_formatted' => showPrice($total_sum_old),
            'total_sale' => $total_sale,
            'total_sale_formatted' => showPrice($total_sale)
        ];
    }

    public static function getUserCart()
    {
        $cart = self::find();

        if (Yii::$app->user->id) {
            $cart->where(['cart.user_id' => Yii::$app->user->id]);
        } else {
            $cart->where(['cart.sess_id' => Yii::$app->session->id]);
        }

        return $cart->all();
    }

    public static function clearCart()
    {
        self::deleteAll([
            'or',
            ['cart.user_id' => Yii::$app->user->id],
            ['cart.sess_id' => Yii::$app->session->id]
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id', 'quantity'], 'integer'],
            [['product_id'], 'required'],
            [['sess_id'], 'string', 'max' => 255],
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
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'quantity' => 'Quantity',
            'sess_id' => 'Sess ID',
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
