<?php

use common\models\Cart;

$carts = Cart::getUserCart();

?>

<table class="table">
    <tbody class="text-center font-family-roboto">
        <?php if (count($carts) == 0) : ?>
            <tr>
                <td colspan="3"><?= t("Ваша корзинка пуста") ?></td>
            </tr>
        <?php endif ?>
        <?php foreach ($carts as $cart) : ?>
            <tr>
                <td class="cart-added px-0 py-30">
                    <div class="row text-left pl-20">
                        <div class="col-3 cart-added__image px-0"><a class="d-block h-100 w-100" href="/product.html" style="background-image: url('<?= $cart->product->path ?>')"></a></div>
                        <div class="col-9 pl-lg-35 pl-20">
                            <a class="gray-text-darker d-block" href="<?= toRoute('/' . $cart->product->category->url) ?>"><?= $cart->product->category->title ?></a>
                            <a class="font-weight-bold gray-text-dark" href="<?= toRoute('/' . $cart->product->url) ?>"><?= $cart->product->title ?></a>
                        </div>
                    </div>
                </td>
                <td class="px-0 py-30 pr-20">
                    <div class="p-10 font-family-roboto text-center">
                        <div class="input-group m-auto">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-number p-0 no-border" data-type="minus"><img src="/img/minus.svg"></button>
                            </span>
                            <input class="form-control input-number text-center no-border font-family-monsterrat" name="quantity" data-cart_id="<?= $cart->id ?>" value="<?= $cart->quantity ?>" min="<?= $cart->product->min_order ?>" max="<?= $cart->product->quantity ?>">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-number p-0 no-border" data-type="plus"><img src="/img/plus.svg"></button>
                            </span>
                        </div>
                        <div class="black-text font-weight-bolder"><?= $cart->quantity ?> x <?= showPrice($cart->product->price) ?> <?= t('сум') ?></div>
                    </div>
                </td>
                <td class="px-0 py-30"><a href="#!" class="delete-cart-btn" data-cart_id="<?= $cart->id ?>" data-message="<?= t("Вы действительно хотите удалить этот продукт?") ?>"><i class="icon_delete"></i></a></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>