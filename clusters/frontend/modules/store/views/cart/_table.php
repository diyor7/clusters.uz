<?php

use common\models\Cart;

$carts = Cart::getUserCart();
?>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr class="active">
                <th><?= t("Фото") ?></th>
                <th><?= t("Товар") ?></th>
                <th>ТН ВЭД</th>
                <th><?= t("Кол-во") ?></th>
                <th><?= t("Цена") ?></th>
                <th><?= t("Сумма") ?></th>
                <th><?= t("Действия") ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($carts) == 0) : ?>
                <tr>
                    <td colspan="8"><?= t("Ваша корзинка пуста") ?></td>
                </tr>
            <?php endif ?>
            <?php foreach ($carts as $cart) : ?>
                <tr>
                    <td>
                        <img src="<?= $cart->product->path ?>" width="50">
                    </td>
                    <td>
                        <a href="<?= toRoute('/store/product/' . $cart->product->url) ?>"><?= $cart->product->title ?></a>
                    </td>
                    <td>4901990000</td>
                    <td class="product-info__quantity">
                        <div class="spin d-flex align-items-center">
                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                <span class="input-group-btn input-group-prepend">
                                    <button class="spin__btn spin__btn--down bootstrap-touchspin-down btn-number" type="button" disabled="disabled" data-type="minus">-</button>
                                </span>
                                <input class="spin__input js-spin form-control input-number add-to-cart-quantity" type="number" data-cart_id="<?= $cart->id ?>" value="<?= $cart->quantity ?>" min="<?= $cart->product->min_order ?>" max="<?= $cart->product->quantity ?>" value="<?= $cart->product->min_order ?>">
                                <span class="input-group-btn input-group-append">
                                    <button class="spin__btn spin__btn--up bootstrap-touchspin-up btn-number" type="button" data-type="plus">+</button>
                                </span>
                            </div>
                            <span class="ml-15 measure"> <?= t("шт.") ?></span>
                        </div>
                    </td>
                    <td>
                        <?= showPrice($cart->product->price) ?> <?= t("сум") ?>
                    </td>
                    <td><?= showPrice($cart->product->price * $cart->quantity) ?> <?= t("сум") ?></td>
                    <td><a class="delete-cart-btn" data-cart_id="<?= $cart->id ?>" href="#!" data-message="<?= t("Вы действительно хотите удалить этот продукт?") ?>"><?= t("Удалить") ?></a> </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <div>

    </div>
</div>