<?php

use common\models\Order;
use common\models\OrderList;
use common\models\ProductReview;

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
<div class="new-bg-different">
    <div class="container py-30">
        <div class="d-flex align-items-start">
            <div class="mr-20">
                <img src="/img/newplatform1.png" alt="">
            </div>
            <div>
                <h1 class="new-title-4 mb-0 pt-2">
                    Электронный магазин
                </h1>
            </div>
        </div>

        <div class="new-breadcrumbs d-flex align-items-center">
            <a href="<?= toRoute('/') ?>"><?=t("Главная")?></a>
            <span></span>
            <a href="<?= toRoute('/store') ?>">Электронный магазин</a>
            <span></span>
            <p><?= $this->title ?></p>
        </div>
    </div>
</div>
<main class="product-info bg-white">
    <div class="container">
        <div class="row mx-xxl-n30 bg-white">
            <div class="col-12 col-xxl-4 py-30 py-xxl-50 d-none d-xxl-block">
                <div id="gallery" class="product-info__gallery owl-carousel owl-theme position-relative">
                    <div class="item rounded-lg" style="background-image: url('<?= $product->path ?>')">
                        <a href="<?= $product->originalPath ?>" class="stretched-link gallery-popup-link">
                            <i class="icon-maximize" title="Увеличить фото"></i>
                        </a>
                    </div>
                    <?php foreach ($product->productImages as $pi) : ?>
                        <div class="item rounded-lg" style="background-image: url('<?= $pi->path ?>')">
                            <a href="<?= $pi->originalPath ?>" class="stretched-link gallery-popup-link">
                                <i class="icon-maximize" title="Увеличить фото"></i>
                            </a>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="col-8 col-xxl-8 pl-15 pl-xxl-30 py-30 py-xxl-50 bg-white">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="product-info__badges text-center mb-10 d-flex">
                            <?php if ($product->price_old && $product->price_old > $product->price) : ?>
                                <div class="product-info__badge product-info__badge--discount">Скидка <?= round(($product->price - $product->price_old) / $product->price * 100) ?>%</div>
                            <?php endif ?>
                        </div>
                        <div class="product-info__reviews mb-15">
                            <span class="mr-35">№ <?= $product->id ?></span>
                            <span class="mr-35">0 продано</span>
                            <img src="/img/stars-<?= round($rating) ?>.svg" alt="">
                            <!-- <span class="mx-20"><?= count($reviews) ?> отзывы</span>
                    <span><?= OrderList::find()->joinWith('order')->where(['order_list.product_id' => $product->id, 'order.status' => Order::STATUS_FINISHED])->sum('quantity') + 0 ?> продано</span> -->
                        </div>
                        <h1 class="new-page-title mb-20"><?= $product->title ?></h1>
                        <div class="product-info__quantity">
                            <div class="product-info__quantity-title mb-10"><?= t("Кол-во") ?></div>
                            <div class="spin d-flex align-items-center">
                                <input class="spin__input js-spin form-control input-number add-to-cart-quantity" type="number" name="quantity" min="<?= $product->min_order ?>" max="<?= $product->quantity ?>" value="<?= $product->min_order ?>">
                                <span class="ml-15"><?= t("шт.") ?></span>
                            </div>
                            <div class="product-info__min-orders mt-5"> <?= t("Мин. заказ") ?>: <?= $product->min_order ?> <?= t("шт.") ?></div>
                        </div>
                        <div class="product-info__price mt-20">
                            <div class="product-info__price product-info__price--new mb-1"> <?= showPrice($product->price) ?> <small><?= t("сум") ?></small></div>
                            <?php if ($product->price_old && $product->price_old > $product->price) : ?>
                                <div class="product-info__price--old"><?= $product->price_old ?> <?= t("сум") ?></div>
                            <?php endif ?>
                        </div>
                        <div class="product-info__btn position-relative z-index-1 mt-0">
                            <button class="btn btn-new mt-15 add-to-cart-btn" data-product_id="<?= $product->id ?>" data-to_route="<?= toRoute('/store/order') ?>"><?= t("Купить") ?></button>
                        </div>
                        <div class="mt-5 text-">
                            <a href="#!" class="favorite-link btn btn-link d-inline-flex align-items-center add-to-favorite" data-product_id="<?= $product->id ?>" data-toggle="tooltip" data-placement="top" data-original-title="<?= \Yii::$app->user->isGuest ? t("Нужна авторизация") : "" ?>">
                                <i class="<?= $product->isFavorite ? 'icon-favorite' : 'icon-star' ?> mr-5"></i>
                                <span>
                                    <?= $product->isFavorite ? t('Удалить из избранных') : t('Добавить в избранное') ?>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="product-info__brief px-15">
                            <dl class="row">
                                <dt class="col-6 odd"><?= t("Идантификационный номер") ?>:</dt>
                                <dd class="col-6 odd">№<?= $product->id ?></dd>
                                <dt class="col-6 even"><?= t("ТН ВЭД код") ?>:</dt>
                                <dd class="col-6 even">1002 00 236 0 22</dd>
                                <dt class="col-6 odd"><?= t("Производитель") ?>:</dt>
                                <dd class="col-6 odd"><?= $product->company->name ?></dd>
                                <dt class="col-6 even"><?= t("Доставка") ?>:</dt>
                                <dd class="col-6 even"><?= $product->deliveryRegions ?></dd>
                                <dt class="col-6 odd"><?= t("Есть в наличии") ?>:</dt>
                                <dd class="col-6 odd"><?= $product->quantity ?> <?= t("шт.") ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-xxl-n30">
            <div class="col-xxl-12 px-xl-15 py-30 px-xxl-30 py-xxl-30 bg-gray">
                <nav>
                    <div class="nav nav-tabs text-uppercase" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link mr-40 pb-25 active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><?= t("Описание") ?></a>
                        <a class="nav-item nav-link mr-40 pb-25" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><?= t("Характеристики") ?></a>
                        <a class="nav-item nav-link pb-25" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false"><?= t("Отзывы") ?> (<?= count($reviews) ?>)</a>
                        <a class="nav-item nav-link ml-40 pb-25 d-block d-xxl-none" id="nav-gallery-tab" data-toggle="tab" href="#nav-gallery" role="tab" aria-controls="nav-gallery" aria-selected="false"><?= t("Фото продукта") ?></a>
                    </div>
                </nav>
                <div class="tab-content pt-30 wow fadeInUp" id="nav-tabContent" style="visibility: visible; animation-name: fadeInUp;">
                    <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <?= $product->description ?>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="product-info__specifications mb-n20">
                            <div class="row">
                                <div class="col-6 col-xxl-12">
                                    <div class="specification mb-20">
                                        <div class="specification__title font-weight-bold mb-5"><?= t("№ товара") ?>:</div>
                                        <div class="specification__text"><?= $product->id ?></div>
                                    </div>
                                </div>
                                <?php foreach ($product->productProperties as $productProperty) : ?>
                                    <div class="col-6 col-xxl-12">
                                        <div class="specification mb-20">
                                            <div class="specification__title font-weight-bold mb-5"><?= $productProperty->property->title ?>:</div>
                                            <div class="specification__text">
                                                <?= $productProperty->propertyValue ? $productProperty->propertyValue->value : $productProperty->value ?>
                                                <?= $productProperty->property->count_unit ?>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach ?>

                                <div class="col-6 col-xxl-12">
                                    <div class="specification mb-20">
                                        <div class="specification__title font-weight-bold mb-5"><?= t("Поставщик") ?>:</div>
                                        <div class="specification__text"><?= $product->company->name ?></div>
                                    </div>
                                </div>
                                <div class="col-6 col-xxl-12">
                                    <div class="specification mb-20">
                                        <div class="specification__title font-weight-bold mb-5"><?= t("Срок доставки") ?>:</div>
                                        <div class="specification__text"><?= $product->deliveryPeriod ?></div>
                                    </div>
                                </div>
                                <div class="col-6 col-xxl-12">
                                    <div class="specification mb-20">
                                        <div class="specification__title font-weight-bold mb-5"><?= t("Тип доставки") ?>:</div>
                                        <div class="specification__text"><?= $product->deliveryType ?></div>
                                    </div>
                                </div>
                                <div class="col-6 col-xxl-12">
                                    <div class="specification mb-20">
                                        <div class="specification__title font-weight-bold mb-5"><?= t("Место доставки товаров") ?>:</div>
                                        <div class="specification__text"><?= $product->deliveryRegions ?></div>
                                    </div>
                                </div>
                                <div class="col-6 col-xxl-12">
                                    <div class="specification mb-20">
                                        <div class="specification__title font-weight-bold mb-5"><?= t("Гарантийное и техническое обслуживание") ?>:</div>
                                        <div class="specification__text"><?= $product->warrantyPeriod ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <div class="product-info-reviews">
                            <div class="review mb-20 pb-20">
                                <?php if (count($reviews) == 0) : ?>
                                    <p class="m-0"><?= t("К данному товару пока что никто не оставил отзыв.") ?></p>
                                <?php endif ?>
                                <?php foreach ($reviews as $review) : ?>
                                    <div class="row">
                                        <div class="col-3 col-xxl-4">
                                            <div class="review__author mt-5 d-flex align-items-center">
                                                <div class="author__photo author__photo--none rounded-circle bg-primary mr-15"><?= $review->user->full_name[0] ?></div>
                                                <div class="author__name">
                                                    <div class="fs-15"><b><?= $review->user->full_name ?></b></div>
                                                    <div class="rating"><img src="img/stars-<?= $review->stars ?>.svg" alt=""></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-9 col-xxl-8">
                                            <div class="review__date fs-14 text-muted mb-5"><?= date("d.m.Y", strtotime($review->created_at)) ?></div>
                                            <div class="review__text fs-15 lh-24"><?= $review->text ?></div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade d-block d-xxl-none" id="nav-gallery" role="tabpanel" aria-labelledby="nav-gallery-tab">
                        <div id="galleryAlt" class="product-info__gallery-alt">
                            <div class="row">
                                <div class="col-3">
                                    <div class="item rounded position-relative" style="background-image: url('<?= $product->path ?>')">
                                        <a href="<?= $product->originalPath ?>" class="stretched-link gallery-popup-link">
                                            <i class="icon-maximize" title="Увеличить фото"></i>
                                        </a>
                                    </div>
                                </div>
                                <?php foreach ($product->productImages as $pi) : ?>
                                    <div class="col-3">
                                        <div class="item rounded position-relative" style="background-image: url('<?= $pi->path ?>')">
                                            <a href="<?= $pi->originalPath ?>" class="stretched-link gallery-popup-link">
                                                <i class="icon-maximize" title="Увеличить фото"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (count($related) > 0) : ?>
                <!-- <div class="col-xxl px-xxl-30 py-30">
                    <div class="relative-products">
                        <h3 class="title text-uppercase mb-30"><?= t("Похожие продуты") ?></h3>
                        <div class="product-grid">
                            <div class="row mx-sm-n10 mx-xxl-n15">
                                <?php foreach ($related as $rel) : ?>
                                    <div class="col-4 col-xxl-2 px-10 px-xxl-15 mb-20 mb-xxl-30">
                                        <div class="product bg-white shadow h-100 wow fadeInUp">
                                            <div class="product__img rounded-right position-relative">
                                                <div class="overflow-hidden rounded-right">
                                                    <div class="product__img-holder" style="background-image: url('<?= $rel->path ?>')"></div>
                                                </div>
                                                <div class="product__badges text-center">
                                                    <?php if ($rel->price_old && $rel->price_old > $rel->price) : ?>
                                                        <div class="product__badge product__badge--discount">Скидка <?= round(($rel->price - $rel->price_old) / $rel->price * 100) ?>%</div>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                            <div class="product__content rounded-left position-relative">
                                                <div class="product__content-top">
                                                    <a href="#!" class="favorite-link favorite-link--active position-absolute add-to-favorite" data-product_id="<?= $rel->id ?>" data-toggle="tooltip" data-placement="top" data-original-title="<?= \Yii::$app->user->isGuest ? t("Нужна авторизация") : "" ?>">
                                                        <i class="<?= $rel->isFavorite ? 'icon-favorite' : 'icon-star' ?>"></i>
                                                    </a>
                                                    <div class="product__id">№ <?= $rel->id ?></div>
                                                    <div class="product__name">
                                                        <a href="product.html"><?= $rel->title ?></a>
                                                    </div>
                                                </div>
                                                <div class="product__content-bottom mt-md-25">
                                                    <div class="product__tn">ТН ВЭД: <a href="#">1000 00 231 0</a></div>
                                                    <div class="product__rating"><img src="/img/stars-5.svg" alt="Рейтинг 5"></div>
                                                    <?php if ($rel->price_old && $rel->price_old > $rel->price) : ?>
                                                        <div class="product__price product__price--old"><small>от</small> <?= showPrice($rel->price_old) ?> <small><?= t('сум') ?></small></div>
                                                    <?php endif ?>
                                                    <div class="product__price product__price--new"><small>от</small> <?= showPrice($rel->price) ?> <small><?= t('сум') ?></small></div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div> -->
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