<?php
/* @var $this yii\web\View */

use common\models\Product;
// mis sanoati klasteri elektron
$this->title = t("Электронный информационно-интерактивный торговый портал по кластеру медной промышленности");
?>
<div class="swiper mySwiper">
    <div class="swiper-wrapper">
        <div class="swiper-slide d-flex flex-wrap align-items-center justify-content-center align-content-center">
            <h1 class="home-title"><?= t("Электронный информационно-интерактивный торговый портал по кластеру медной промышленности") ?></h1>

            <div class="front-page__search mb-50 w-100 mt-50">
                <div class="row justify-content-center">
                    <div class="col-10 col-xxl-8">
                        <form class="d-flex justify-content-center w-100" method="GET" action="<?= toRoute('/store/search') ?>">
                            <div class="input-box d-flex w-100 align-items-center">
                                <img src="/img/search.svg" alt="">
                                <input type="text" class="form-control w-100" id="q" placeholder="<?= t("Поиск товаров") ?>" name="query">
                            </div>
                            <button type="submit" class="btn btn-secondary"><?= t("Найти товар") ?></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="text-center arrowDown" onclick="window.swiper.slideTo(1)">
                <div>
                    <img src="/img/mouse.svg" alt="">
                </div>
                <div class="">
                    <img src="/img/arrow-down.svg" alt="">
                </div>
            </div>
        </div>
        <div class="swiper-slide pt-170 d-flex flex-wrap align-items-start justify-content-start align-content-start position-relative">
            <div class="container">
                <h2 class="home-title-2 text-left"><?= t("Предприятия медного кластера") ?></h2>

                <div class="row mt-75">
                    <div class="col-md-3">
                        <a href="http://agmk.clusters.uz/">
                            <div class="cluster">
                                <div class="image d-flex align-items-center justify-content-center">
                                    <img src="/img/cluster1.svg">
                                </div>
                                <h3>
                                    АО "Алмалыкский горно-металлургический комбинат"
                                </h3>

                                <p>
                                    <?= t("Торги") ?>
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="http://uzeltech.clusters.uz/">
                            <div class="cluster">
                                <div class="image d-flex align-items-center justify-content-center">
                                    <img src="/img/cluster2.svg">
                                </div>
                                <h3>
                                    АП "Электротехнической промышленности Узбекистана"
                                </h3>

                                <p>
                                    <?= t("Торги") ?>
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="http://umk.clusters.uz/">
                            <div class="cluster">
                                <div class="image d-flex align-items-center justify-content-center">
                                    <img src="/img/cluster3.svg">
                                </div>
                                <h3>
                                    АО "Узбекский металлургический комбинат"
                                </h3>

                                <p>
                                    <?= t("Торги") ?>
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="http://ngmk.clusters.uz/">
                            <div class="cluster">
                                <div class="image d-flex align-items-center justify-content-center">
                                    <img src="/img/cluster4.svg">
                                </div>
                                <h3>
                                    Навоийский горно-металлургический комбинат
                                </h3>

                                <p>
                                    <?= t("Торги") ?>
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="text-center arrowDown arrow-down" onclick="window.swiper.slideTo(2)">
                    <div>
                        <img src="/img/mouse.svg" alt="">
                    </div>
                    <div class="">
                        <img src="/img/arrow-down.svg" alt="">
                    </div>
                </div>
            </div>
        </div>

        <div class="swiper-slide pt-170 d-flex flex-wrap align-items-start justify-content-start align-content-start position-relative">
            <div class="container">
                <h2 class="home-title-2 text-left"><?= t("Закупы по площадкам") ?></h2>

                <div class="row mt-75">
                    <div class="col-md-6 col-lg-6 col-xl-3 mb-4">
                        <a href="<?= toRoute('/store') ?>">
                            <div class="platform text-left">
                                <div class="image">
                                    <img src="/img/platform1.svg" alt="">
                                </div>
                                <h3>
                                    <?= t("Электронный магазин") ?>
                                </h3>
                                <p>
                                    <?= t("Государственная закупка однотипных товаров") ?>
                                </p>
                            </div>
                        </a>

                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 mb-4">
                        <a href="<?= toRoute('/auction') ?>">
                            <div class="platform text-left">
                                <div class="image">
                                    <img src="/img/platform2.svg" alt="">
                                </div>
                                <h3>
                                    <?= t("Аукцион") ?>
                                </h3>
                                <p>
                                    <?= t("Аукцион на понижение стартовой цены - Государственная закупка товаров со стандартными свойствами") ?>
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 mb-4">
                        <a href="#!" onclick="toastr.info('На стадии разработки')">
                            <div class="platform text-left">
                                <div class="image">
                                    <img src="/img/platform3.svg" alt="">
                                </div>
                                <h3>
                                    <?= t("Тендер") ?>
                                </h3>
                                <p>
                                    <?= t("Критерии определения победителя имеют не только денежную, но количественную и качественную оценку государственной закупки товара (работы, услуги)") ?>
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 mb-4">
                        <a href="#!" onclick="toastr.info('На стадии разработки')">
                            <div class="platform text-left">
                                <div class="image">
                                    <img src="/img/platform4.svg" alt="">
                                </div>
                                <h3>
                                    <?= t("Электронный конкурс") ?>
                                </h3>
                                <p>
                                    <?= t("Критерии определения победителя имеют не только денежную, но количественную и качественную оценку государственной закупки товара (работы, услуги)") ?>
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="text-center arrowDown arrow-down" onclick="window.swiper.slideTo(3)">
                    <div>
                        <img src="/img/mouse.svg" alt="">
                    </div>
                    <div class="">
                        <img src="/img/arrow-down.svg" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-slide pt-170 d-flex flex-wrap align-items-start justify-content-start align-content-start position-relative">
            <div class="container">
                <h2 class="home-title-2 text-left"><?= t("Выпускаемая продукция") ?></h2>

                <div class="home-products">
                    <div class="swiper product-swiper text-left mt-70">
                        <div class="swiper-wrapper">
                            <?php $products = Product::find()
                                ->select(['product.*, (select count(*) from favorite where favorite.product_id = product.id) as fav_count'])
                                ->where(['status' => Product::STATUS_ACTIVE])
                                ->orderBy("fav_count desc")
                                ->limit(10)->all(); ?>
                            <?php foreach ($products as $product) : ?>
                                <div class="swiper-slide">
                                    <a href="<?= toRoute('/store/product/' . $product->url) ?>">
                                        <div class="home-product">
                                            <div class="home-product-header text-left">
                                                № <?= $product->id ?>
                                            </div>
                                            <div class="home-product-image">
                                                <img src="<?= $product->path ?>" alt="">
                                            </div>
                                            <div class="home-product-name text-left">
                                                <?= $product->title ?>
                                            </div>
                                            <div class="home-product-price text-left">
                                                <?= showPrice($product->price) ?> <span><?= t("сум") ?></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>

                <div class="text-center arrowUp arrow-down" onclick="window.swiper.slideTo(2)">
                    <div class="">
                        <img src="/img/arrow-up.svg" alt="">
                    </div>
                    <div>
                        <img src="/img/mouse.svg" alt="">
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php
    $this->registerJs("
    $(document).ready(function() {
        var swiper = new Swiper('.mySwiper', {
            direction: 'vertical',
            speed: 600,
            
            slidesPerView: 1,
            spaceBetween: 0,
            mousewheel: true,
            // allowTouchMove: false
        });

        window.swiper = swiper;

        var productPwiper = new Swiper('.product-swiper', {
            slidesPerView: 5,
            spaceBetween: 28,
            mousewheel: true,
        });
    });
", \yii\web\View::POS_END);
    ?>