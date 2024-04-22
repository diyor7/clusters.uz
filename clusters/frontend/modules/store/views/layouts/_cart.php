<?php

use common\models\Cart;

?>

<div class="cart-slide-left position-fixed bg-white overflow-hidden slide-right" id="slide-right">
    <h2 class="px-30 py-40 fs-20 font-weight-bold black-text text-left gray-bg">
        <?=t("Корзинка")?>
        <a class="float-right toggle-slide-right" href="#!" data-slide="slide-right"><i class="icon_close"></i></a>
    </h2>
    <div class="px-20 cart-slide-left__content w-100">
        <div class="cart">
            <div class="nav-cart-table">
                <?= $this->render("_cart_table") ?>
            </div>
        </div>
    </div>
    <div class="gray-bg d-flex w-100 px-40 py-25 position-absolute fixed-bottom">
        <h2 class="fs-26 black-text text-left">
            <span class="font-family-roboto fs-16 whitespace-nowrap"><?= t('Всего к оплате') ?></span>
            <span class="d-block font-weight-bold whitespace-nowrap">
                <span class="cart-total-sum"><?= Cart::getUserCartData()['total_sum_formatted'] ?></span>
                <?= t('сум') ?>
            </span>
        </h2>
        <div class=""><a class="fs-18 whitespace-nowrap" href="<?= toRoute('/cart') ?>"><?= t("Перейти в корзину") ?><i class="icon_right_narrow ml-15"></i></a></div>
    </div>
</div>