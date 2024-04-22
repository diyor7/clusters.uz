<?php

namespace frontend\modules\store\controllers;

use common\models\Address;
use common\models\Cart;
use common\models\Company;
use common\models\CompanyTransaction;
use common\models\Notification;
use common\models\Order;
use common\models\OrderList;
use common\models\User;
use frontend\controllers\FrontendController;
use Yii;
use yii\web\NotFoundHttpException;

class OrderController extends FrontendController
{
    public function actionIndex()
    {
        $cart_data = Cart::getUserCartData();

        if ($cart_data['quantity'] === 0) {
            Yii::$app->session->setFlash('danger', t("Чтобы оформить заказ, добавьте товары в корзину."));

            return $this->goHome();
        }

        $total_sum = $cart_data['total_sum'];

        $user = User::findOne(Yii::$app->user->id);

        $addresses = Address::findAll(['user_id' => Yii::$app->user->id]);

        $order = new Order([
            'payment_type' => Order::PAYMENT_TYPE_CASH,
            'delivery_type' => Order::DELIVERY_TYPE_FREE_SHIPPING,
            'address_id' => count($addresses) > 0 ? $addresses[0]->id : null,
            'receiver_fio' => $user && $user->user_profile ? $user->user_profile->full_name : "",
            'receiver_phone' => $user && preg_match('/^\+998[0-9]{9}$/', $user->username) ? $user->username : null,
            'total_sum' => $total_sum
        ]);

        if ($order->load($_POST) && $order->validate()) {

            if (!Yii::$app->session->has("checked_key") || Yii::$app->session->has("checked_key") && Yii::$app->session->get("checked_key") == false) {
                Yii::$app->session->setFlash("danger", t("Не удалось принять запрос. Не подтверждён ключом."));
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                Yii::$app->session->remove("checked_key");
            }
            
            $carts = Cart::getUserCart();

            // нельзя верить пользователям, поэтому присваиваем некоторые данные после загрузки
            $order->user_id = Yii::$app->user->id;
            $order->company_id = $carts[0]->product->company_id;
            $order->total_sum = $total_sum;
            $order->payment_status = Order::PAYMENT_STATUS_WAITING;
            $order->shipping_sum = 0;
            $order->address_text = $order->address ? $order->address->text : null;
            $order->created_at = date("Y-m-d H:i:s");

            $type = $user ? $user->companyType : Company::TYPE_PHYSICAL;

            if ($type == Company::TYPE_PHYSICAL) { // для физ и частных лиц
                $order->type = Order::TYPE_GENERAL;
                $order->status = Order::STATUS_CREATED;
            } else {
                $order->type = Order::TYPE_TENDER;
                $order->status = Order::STATUS_WAITING_ACCEPT;
                $order->request_end = date("Y-m-d H:i:s", strtotime("+48 hour", strtotime($order->created_at)));

                if ($user->availableBalance < $cart_data['total_block_sum']) { // Недостаточно средств 
                    Yii::$app->session->setFlash('danger', t("Недостаточно средств на вашем балансе в системе"));
                    return $this->redirect(['index']);
                }
            }

            if ($order->save()) {
                foreach ($carts as $cart) {
                    $cache = [
                        'product' => array_merge(
                            $cart->product->attributes,
                            [
                                'name' => $cart->product->getProductTranslates()->where(['lang' => 1])->one()->title,
                                'category_name' => $cart->product->category->getCategoryTranslates()->where(['lang' => 1])->one()->title,
                                'description' => $cart->product->getProductTranslates()->where(['lang' => 1])->one()->description
                            ]
                        ),
                        'properties' => $cart->product->propertiesCache
                    ];

                    $order_list = new OrderList([
                        'order_id' => $order->id,
                        'product_id' => $cart->product_id,
                        'quantity' => $cart->quantity,
                        'price' => $cart->product->price,
                        'cache' => json_encode($cache)
                    ]);

                    if ($order_list->save()) {
                        $cart->delete();
                    } else {
                        Yii::$app->session->setFlash('danger', t("Произошла ошибка при оформление заказа, повторите попытку."));
                        return $this->goHome();
                    }
                }

                if ($order->type == Order::TYPE_TENDER) {
                    $zalog_transaction = new CompanyTransaction([
                        'company_id' => $user->company_id,
                        'currency' => $cart_data['deposit_sum'],
                        'type' => CompanyTransaction::TYPE_ZALOG,
                        'order_id' => $order->id,
                        'description' => t(""),
                        'status' => CompanyTransaction::STATUS_SUCCESS
                    ]);

                    $komission_transaction = new CompanyTransaction([
                        'company_id' => $user->company_id,
                        'currency' => $cart_data['commission_sum'],
                        'type' => CompanyTransaction::TYPE_BLOCK_COMMISION,
                        'order_id' => $order->id,
                        'description' => t(""),
                        'status' => CompanyTransaction::STATUS_SUCCESS
                    ]);

                    if ($zalog_transaction->save() && $komission_transaction->save()) {
                        Yii::$app->session->setFlash("success", t("С вашего баланса снято {zalog} сум в виде залога и {komissiya} сум в виде удержания комиссионного сбора.", [
                            'zalog' => showPrice($cart_data['deposit_sum']),
                            'komissiya' => showPrice($cart_data['commission_sum'])
                        ]));
                    } else {
                        $zalog_transaction->delete();
                        $komission_transaction->delete();
                    }
                }

                Yii::$app->session->set("order_id", $order->id);
                return $this->redirect(['success']);
            }
        }

        return $this->render('index', [
            'order' => $order,
            'user' => $user,
            'cart_data' => $cart_data
        ]);
    }

    public function actionSuccess()
    {
        $order_id = Yii::$app->session->get("order_id");

        $order = Order::findOne(['id' => $order_id, 'user_id' => Yii::$app->user->id]);

        if (!$order) throw new NotFoundHttpException(t("Страница не найдена"));

        $user = User::findOne(Yii::$app->user->id);

        return $this->render("success", [
            'order' => $order,
            'user' => $user
        ]);
    }
}
