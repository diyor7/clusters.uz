<?php

use common\models\Cart;
use common\models\Company;

$this->title = t("Корзинка");

$this->params['breadcrumbs'][] = $this->title;

$type = $user ? $user->companyType : Company::TYPE_PHYSICAL;
?>
<main>
    <div class="page-head py-xl-30 wow fadeInUp">
        <div class="container">
            <h1 class="page-title mb-0"><?= $this->title ?></h1>
        </div>
    </div>
    <div class="mb-30 shadow position-relative wow fadeInUp"></div>

    <div class="container mb-30">
        <div class="row">
            <div class="col">
                <div class="shadow rounded bg-white p-20">
                    <?= $this->render("_table") ?>
                </div>
            </div>
            <div class="col-3">
                <div class="shadow rounded bg-white p-20">
                    <div class="form-group field-ordersreceived-company_id required">

                        <input type="hidden" id="ordersreceived-company_id" class="form-control" name="OrdersReceived[company_id]" value="79448" options="{&quot;class&quot;:&quot;form-group cols&quot;}">

                        <div class="invalid-feedback"></div>
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th colspan="2" class="text-center"><?= t('Подсчет корзины') ?></th>
                            </tr>
                            <tr>
                                <td><?= t('Товары') ?> (<?= Cart::getUserCartData()['quantity'] ?>):</td>
                                <td class="text-right"> <span class="cart-total-sum-old"><?= Cart::getUserCartData()['total_sum_old_formatted'] ?></span> <?= t("сум") ?></td>
                            </tr>
                            <tr>
                                <td><?= t('Скидки на товары') ?>:</td>
                                <td class="text-right">−<span class="cart-sale"><?= Cart::getUserCartData()['total_sale_formatted'] ?></span> <?= t("сум") ?></td>
                            </tr>

                            <?php if ($type == Company::TYPE_BUDGET || $type == Company::TYPE_COPERATE || $type == Company::TYPE_PRIVATE) : ?>
                                <tr>
                                    <td><?= t('Общая начальная сумма') ?>:</td>
                                    <td class="text-right"><span class="cart-total-sum"><?= Cart::getUserCartData()['total_sum_formatted'] ?></span> <?= t("сум") ?></td>
                                </tr>
                                <tr>
                                    <td><?= t('Сумма залога') ?>:</td>
                                    <td class="text-right"><span class="cart-deposit-sum"><?= showPrice(Cart::getUserCartData()['deposit_sum']) ?></span> <?= t("сум") ?></td>
                                </tr>
                                <tr>
                                    <td><?= t('Комиссионный сбор') ?>:</td>
                                    <td class="text-right"><span class="cart-commission-sum"><?= showPrice(Cart::getUserCartData()['commission_sum']) ?></span> <?= t("сум") ?></td>
                                </tr>
                                <tr>
                                    <th><?= t('Общая блокированная сумма') ?>:</th>
                                    <th class="text-right"><span class="cart-total-block-sum"><?= showPrice(Cart::getUserCartData()['total_block_sum']) ?></span></th>
                                </tr>
                            <?php else : ?>
                                <tr>
                                    <td><?= t('Общая сумма') ?>:</td>
                                    <td class="text-right"><span class="cart-total-sum"><?= Cart::getUserCartData()['total_sum_formatted'] ?></span> <?= t("сум") ?></td>
                                </tr>
                            <?php endif ?>
                            <tr>
                                <th colspan="2">
                                    <div class="form-group">
                                        <a class="btn btn-spec btn-block py-10 mr-10" href="<?= toRoute('/store/order') ?>">
                                            <?= t('Оформить заказ') ?>
                                        </a>
                                    </div>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>