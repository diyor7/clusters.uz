<?php

use common\models\Order;
use common\models\ProductReview;
use common\models\User;

$this->title = $product->title;

if ($product->category->parent)
    $this->params['breadcrumbs'][] = array(
        'label' => $product->category->parent->title,
        'url' => toRoute('/' . $product->category->parent->url)
    );

if ($product->category)
    $this->params['breadcrumbs'][] = array(
        'label' => $product->category->title,
        'url' => toRoute('/' . $product->category->url)
    );

$this->params['breadcrumbs'][] = $this->title;

$rating = ProductReview::find()->where(['product_id' => $product->id])->average('stars');

$reviews = $product->productReviews;

?>
<div class="bg-white">
    <div class="container py-30">
        <div class="d-flex align-items-start">
            <div class="mr-20">
                <a href="<?= toRoute('/store/category') ?>">
                    <img src="/img/newplatform1.png" alt="">
                </a>
            </div>
            <div>
                <h1 class="new-title-4 mb-0 pt-2">
                    <?= t("Электронный магазин") ?>
                </h1>
            </div>
        </div>

        <div class="new-breadcrumbs d-flex align-items-center">
            <a href="<?= toRoute('/') ?>"><?= t("Главная") ?></a>
            <span></span>

            <a href="<?= toRoute('/store/category') ?>"><?= t("Электронный магазин") ?></a>
            <span></span>

            <a href="<?= toRoute('/store/' . $product->category->url) ?>"><?= $product->category->title ?></a>
            <span></span>

            <p><?= $this->title ?></p>
        </div>
    </div>
</div>
<main class="product-info new-bg-different">
    <div class="container">
        <div class="row mx-xxl-n30 ">
            <div class="col-12 col-lg-4 py-30 py-xxl-50 ">
                <div id="" class="product-info__gallery  position-relative">
                    <div class="item rounded-lg" style="background-image: url('<?= $product->path ?>')">
                        <a href="<?= $product->originalPath ?>" class="stretched-link gallery-popup-link">
                            <i class="icon-maximize" title="<?=t('Увеличить фото')?>"></i>
                        </a>
                    </div>
                </div>
                <div class="row align-items-center">
                    <?php foreach ($product->productImages as $pi) : ?>
                        <div class="col-3 mb-4">
                            <a href="<?= $pi->originalPath ?>" class="stretched-link gallery-popup-link">
                                <img src="<?= $pi->path ?>" alt="">
                            </a>
                        </div>
                    <?php endforeach ?>
                </div>

            </div>
            <div class="col-8 col-lg-8 pl-15 pl-xxl-30 py-30 py-xxl-50 ">
                <div class="row">
                    <div class="col-12">
                        <div class="product-info__badges text-center mb-10 d-flex">
                            <?php if ($product->price_old && $product->price_old > $product->price) : ?>
                                <div class="product-info__badge product-info__badge--discount"> <?=t('Скидка') . ' ' . round(($product->price - $product->price_old) / $product->price * 100) ?>%</div>
                            <?php endif ?>
                        </div>
                        <div class="product-info__reviews mb-15">
                            <span class="mr-35">№ <?= $product->id ?></span>
                            <span class="mr-35"><?=t('{m} шт. продано', [
                                    'm' => 0
                                ])?></span>
                            <img src="/img/stars-<?= round($rating) ?>.svg" alt="">
                        </div>
                        <h1 class="new-page-title mb-20"><?= $product->title ?></h1>
                    </div>
                    <div class="col-lg-6">
                        <?php if (Yii::$app->user->isGuest || !Yii::$app->user->isGuest && Yii::$app->user->identity->type != User::TYPE_PRODUCER && $product->company_id != Yii::$app->user->identity->company_id) : ?>
                            <div class="product-info__quantity">
                                <div class="spin d-flex align-items-center">
                                    <input class="spin__input js-spin form-control input-number add-to-cart-quantity" type="number" name="quantity" min="<?= $product->min_order ?>" max="<?= $product->quantity ?>" value="<?= $product->min_order ?>">
                                    <span class="ml-15"><?= t("шт.") ?></span>
                                </div>
                                <div class="product-info__min-orders mt-5"> <?= t("Мин. заказ") ?>: <?= $product->min_order ?> <?= t("шт.") ?></div>
                            </div>
                        <?php endif ?>
                        <div class="product-info__price mt-20">
                            <div class="product-info__price product-info__price--new mb-1"> <?= showPrice($product->price) ?> <small><?= t("сум") ?></small></div>
                            <?php if ($product->price_old && $product->price_old > $product->price) : ?>
                                <div class="product-info__price--old"><?= $product->price_old ?> <?= t("сум") ?></div>
                            <?php endif ?>
                        </div>
                        <?php if (Yii::$app->user->isGuest || !Yii::$app->user->isGuest && Yii::$app->user->identity->type != User::TYPE_PRODUCER && $product->company_id != Yii::$app->user->identity->company_id) : ?>
                            <div class="product-info__btn position-relative z-index-1 mt-0">
                                <button class="btn btn-new mt-15 add-to-cart-btn" data-product_id="<?= $product->id ?>" data-to_route="<?= toRoute('/store/order') ?>"><?= t("Купить") ?></button>
                            </div>
                        <?php endif ?>
                        <?php if (Yii::$app->user->isGuest || !Yii::$app->user->isGuest && Yii::$app->user->identity->type != User::TYPE_PRODUCER && $product->company_id != Yii::$app->user->identity->company_id) : ?>
                            <div class="mt-25 text-">
                                <a href="#!" class="favorite-link btn btn-link d-inline-flex align-items-center add-to-favorite px-0" data-product_id="<?= $product->id ?>" data-toggle="tooltip" data-placement="top" data-original-title="<?= \Yii::$app->user->isGuest ? t("Нужна авторизация") : "" ?>">
                                    <i class="<?= $product->isFavorite ? 'icon-favorite' : 'icon-star' ?> mr-5"></i>
                                    <span>
                                        <?= $product->isFavorite ? t('Удалить из избранных') : t('Добавить в избранное') ?>
                                    </span>
                                </a>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="col-lg-6">
                        <div class="product-info__brief px-15">
                            <dl class="row">
                                <!-- <dt class="col-6 odd"><?= t("Ид. номер") ?>:</dt>
                                <dd class="col-6 odd">№<?= $product->id ?></dd>
                                <dt class="col-6 even"><?= t("ТН ВЭД код") ?>:</dt>
                                <dd class="col-6 even">1002 00 236 0 22</dd>
                                <dt class="col-6 odd"><?= t("Производитель") ?>:</dt>
                                <dd class="col-6 odd"><?= $product->company->name ?></dd>
                                <dt class="col-6 even"><?= t("Доставка") ?>:</dt>
                                <dd class="col-6 even"><?= $product->deliveryRegions ?></dd>
                                <dt class="col-6 odd"><?= t("Есть в наличии") ?>:</dt>
                                <dd class="col-6 odd"><?= $product->quantity ?> <?= t("шт.") ?></dd> -->
                                <dt class="col-6 pl-0 odd"><?= t("Гарантийный срок") ?>:</dt>
                                <dd class="col-6 pr-0 odd"><?= $product->warrantyPeriod ?></dd>
                                <dt class="col-6 pl-0 odd"><?= t("В наличии") ?>:</dt>
                                <dd class="col-6 pr-0 odd"><?= $product->quantity ?></dd>
                                <?php if($product->delivery_type == Order::DELIVERY_TYPE_FREE_SHIPPING): ?>
                                    <dt class="col-6 pl-0 even"><?= t("Срок доставки") ?>:</dt>
                                    <dd class="col-6 pr-0 even"><?= $product->deliveryPeriod ?></dd>
                                    <dt class="col-6 pl-0 odd"><?= t("Место доставки") ?>:</dt>
                                    <dd class="col-6 pr-0 odd"><?= $product->deliveryRegions ?></dd>
                                <?php else: ?>
                                    <dt class="col-6 pl-0 even"><?= t("Время взять это") ?>:</dt>
                                    <dd class="col-6 pr-0 even"><?= $product->deliveryPeriod ?></dd>
                                    <dt class="col-6 pl-0 odd"><?= t("Адрес") ?>:</dt>
                                    <dd class="col-6 pr-0 odd"><?= $product->delivery_address ?></dd>
                                <?php endif; ?>
                                
                                <dt class="col-6 pl-0 even"><?= t("Категория") ?>:</dt>
                                <dd class="col-6 pr-0 even">
                                    <a href="<?= toRoute('/store/' . $product->category->url) ?>">
                                        <?= $product->category ? $product->category->title : "" ?>
                                    </a>
                                </dd>
                            </dl>
                        </div>

                        <div class="product-normativ">
                            <h4><?= t("Нормативный документ (ГОСТ, ОСТ, ТУ и другие)") ?></h4>
                            <p><?= t("Соответствие стандарту производителя") ?></p>
                        </div>
                    </div>
                    <div class="col-12 mt-35">
                        <div class="product-new-description">
                            <h4><?= t("Технические характеристики") ?></h4>
                            <div class="content">
                                <?= $product->description ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-xxl-n30">


            <?php if (count($related) > 0) : ?>
                <div class="col-xxl px-xxl-30 py-30">
                    <div class="relative-products">
                        <h3 class="title text-uppercase mb-30"><?= t("Похожие продуты") ?></h3>
                        <div class="product-grid">
                            <div class="row mx-sm-n10 mx-xxl-n15">
                                <?php foreach ($related as $rel) : ?>
                                    <?= \frontend\widgets\Product::widget(['product' => $rel]) ?>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</main>

<?php
$this->registerJs('
$(document).ready(function(){
    $(".js-spin").each(function(i,el) {
      var min = el.getAttribute("min") || 10,
        max = el.getAttribute("max") || 500;
      $(el).TouchSpin({
        min: min,
        max: max,
        buttondown_class: "spin__btn spin__btn--down",
        buttonup_class: "spin__btn spin__btn--up"
      });
    });

    $("#gallery").owlCarousel({
        loop: false,
        margin: 20,
        items: 1,
        nav: true,
        navText:[
            "<i class=\"icon-chevron-left fs-24 align-text-top\"></i>",
            "<i class=\"icon-chevron-right fs-24 align-text-top\"></i>"
        ],
        dots: false
    });

    $(".gallery-popup-link").magnificPopup({
        type: "image",
        gallery: {
            navigateByImgClick: true,
            enabled: true
        }
    });
  });
', 3);
?>