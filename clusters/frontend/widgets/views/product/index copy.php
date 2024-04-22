<?php

?>
<div class="col-3 col-xxl-2 px-10 px-xxl-15 mb-20 mb-xxl-30">
    <div class="product bg-white shadow h-100 wow fadeInUp">
        <div class="product__img rounded-right position-relative">
            <div class="overflow-hidden rounded-right">
                <a href="<?= toRoute('/store/product/' . $product->url) ?>">
                    <div class="product__img-holder" style="background-image: url('<?= $product->path ?>')"></div>
                </a>
            </div>
            <div class="product__badges text-center">
                <?php if ($product->price_old && $product->price_old > $product->price) : ?>
                    <div class="product__badge product__badge--discount">Скидка <?= round(($product->price - $product->price_old) / $product->price * 100) ?>%</div>
                <?php endif ?>
            </div>
        </div>
        <div class="product__content rounded-left position-relative">
            <div class="product__content-top">
                <a href="#!" class="favorite-link favorite-link--active position-absolute add-to-favorite" data-product_id="<?= $product->id ?>" data-toggle="tooltip" data-placement="top" data-original-title="<?= \Yii::$app->user->isGuest ? t("Нужна авторизация") : "" ?>">
                    <i class="<?= $product->isFavorite ? 'icon-favorite' : 'icon-star' ?>"></i>
                </a>
                <div class="product__id">№ <?= $product->id ?></div>
                <div class="product__name">
                    <a href="<?= toRoute('/store/product/' . $product->url) ?>"><?= $product->title ?></a>
                </div>
            </div>
            <div class="product__content-bottom mt-md-25">
                <div class="product__tn">ТН ВЭД: <a href="#">1000 00 231 0</a></div>
                <div class="product__rating"><img src="/img/stars-<?= $product->rating ?>.svg" alt="Рейтинг 5"></div>

                <?php if ($product->price_old && $product->price_old > $product->price) : ?>
                    <div class="product__price product__price--old"><small>от</small> <?= showPrice($product->price_old) ?>
                        <small><?= t('сум') ?></small>
                    </div>
                <?php endif ?>

                <div class="product__price product__price--new"><small>от</small> <?= showPrice($product->price) ?>
                    <small> <?= t('сум') ?></small>
                </div>
            </div>
        </div>

    </div>
</div>