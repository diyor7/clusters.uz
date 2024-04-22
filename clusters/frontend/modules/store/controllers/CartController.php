<?php

namespace frontend\modules\store\controllers;

use common\models\Cart;
use common\models\Product;
use common\models\User;
use frontend\controllers\FrontendController;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CartController extends FrontendController
{
    public function actionIndex()
    {
        $user = User::findOne(Yii::$app->user->id);

        return $this->render('index', [
            'user' => $user
        ]);
    }

    private function checkExists($product)
    {
        $cart = Cart::find();

        if (Yii::$app->user->id) {
            $cart->andWhere(['cart.user_id' => Yii::$app->user->id]);
        } else {
            $cart->andWhere(['cart.sess_id' => Yii::$app->session->id]);
        }

        if ($cart->count() > 0) {
            if ($cart->joinWith('product')->andWhere(['!=', 'product.company_id', $product->company_id])->count() > 0) {
                return true;
            }
        }

        return false;
    }

    public function actionAddToCart($quantity, $product_id, $clear = false)
    {
        if (Yii::$app->request->isAjax && $quantity > 0) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $product = Product::findOne($product_id);

            if (!$product) throw new NotFoundHttpException(t("Товар не найден."));

            if ($clear == 1) {
                Cart::clearCart();
            }

            $cart = Cart::find()->where(['cart.product_id' => $product_id]);

            if (Yii::$app->user->id) {
                $cart->andWhere(['cart.user_id' => Yii::$app->user->id]);
            } else {
                $cart->andWhere(['cart.sess_id' => Yii::$app->session->id]);
            }

            $cart = $cart->one();

            if (!$cart) {
                if (!$this->checkExists($product))
                    $cart = new Cart([
                        'user_id' => Yii::$app->user->id,
                        'sess_id' => Yii::$app->session->id,
                        'product_id' => $product_id,
                        'quantity' => 0
                    ]);
                else {
                    return [
                        'status' => 'error',
                        'message' => t('Вы можете добавить товары в корзину только с одного продавца, чтобы добавить этого товара завершите заказ с предыдущим продавцом.')
                    ];
                }
            }

            $cart->quantity += $quantity;

            if ($cart->quantity > $cart->product->quantity) {
                $cart->quantity = $cart->product->quantity;
            }

            if ($cart->quantity < $cart->product->min_order) {
                $cart->quantity = $cart->product->min_order;
            }

            if ($cart->save()) {
                return [
                    'status' => 'success',
                    'data' => Cart::getUserCartData(),
                    'table' => $this->renderAjax('../layouts/_cart_table'),
                    'cart' => $this->renderAjax('_table'),
                    'message' => t("Товар добавлен в корзину. Текущее количество товара в корзине: " . $cart->quantity)
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Can not save'
                ];
            }
        }

        throw new BadRequestHttpException();
    }

    public function actionUpdateQuantity($cart_id, $quantity)
    {
        if (Yii::$app->request->isAjax && $quantity > 0) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $cart = Cart::find()->where(['id' => $cart_id]);

            if (Yii::$app->user->isGuest) {
                $cart->andWhere(['sess_id' => Yii::$app->session->id]);
            } else {
                $cart->andWhere(['user_id' => Yii::$app->user->id]);
            }

            $cart = $cart->one();

            if (!$cart) throw new NotFoundHttpException(t("Корзина не найдена."));

            if ($quantity >= $cart->product->min_order && $quantity <= $cart->product->quantity) {
                $cart->quantity = $quantity;

                if ($cart->save()) {
                    return [
                        'status' => 'success',
                        'message' => t("Товар добавлен в корзину. Текущее количество товара в корзине: " . $cart->quantity),
                        'data' => Cart::getUserCartData(),
                        'table' => $this->renderAjax('../layouts/_cart_table'),
                        'cart' => $this->renderAjax('_table'),
                        'line_total_sum' => $cart->quantity * $cart->product->price,
                        'line_total_sum_formatted' => showPrice($cart->quantity * $cart->product->price)
                    ];
                }
            }

            return [
                'status' => 'error',
                'message' => 'Can not save'
            ];
        }

        throw new BadRequestHttpException();
    }

    public function actionDeleteCart()
    {
        $cart_id = Yii::$app->request->post("cart_id");

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost && $cart_id) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $cart = Cart::find()->where(['id' => $cart_id]);

            if (Yii::$app->user->isGuest) {
                $cart->andWhere(['sess_id' => Yii::$app->session->id]);
            } else {
                $cart->andWhere(['user_id' => Yii::$app->user->id]);
            }

            $cart = $cart->one();

            if (!$cart) throw new NotFoundHttpException(t("Корзина не найдена."));

            if ($cart->delete() !== false) {
                return [
                    'status' => 'success',
                    'message' => t("Товар удален из корзины."),
                    
                    'data' => Cart::getUserCartData(),
                    'table' => $this->renderAjax('../layouts/_cart_table'),
                    'cart' => $this->renderAjax('_table'),
                ];
            }

            return [
                'status' => 'error',
                'message' => 'Can not delete'
            ];
        }

        throw new BadRequestHttpException();
    }
}
