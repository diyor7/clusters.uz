<?php

use common\models\Order;
use common\models\User;
use yii\widgets\ActiveForm;

$this->title = t("Запрос цен") . " №" . $order->id;

$this->params['breadcrumbs'][] = array(
    'label' => t("Запросы цен"),
    'url' => toRoute('/trade/index')
);

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="new-bg-different py-30">
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <h2 class="cabinet-title-1"><?= $this->title ?></h2>
                        <div class="cabinet-breadcrumb">
                            <a href="<?= toRoute('/') ?>"><?= t("Главная") ?></a>
                            <span>/</span>
                            <a href="<?= toRoute(['/trade/index']) ?>"><?= t("Закупки") ?></a>
                            <span>/</span>
                            <p><?= $this->title ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="d-doc bg-white shadow rounded h-100">
                    <div class="d-doc__body p-30 mt-30">
                        <div class="row">
                            <div class="col-12 col-xxl-12">
                                <div class="row mb-10 align-items-center">
                                    <div class="col-12">
                                        <div class="d-doc__total">
                                            <a class="" href="#!" onclick="window.print()">
                                                <i class="icon-printer"></i>
                                            </a>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="d-doc__title"><?= t("Общая сумма") ?>:</div>
                                                    <div class="d-doc__text d-doc-text--price fs-24 font-weight-bold">‭<?= showPrice($order->total_sum) ?> <?= t("сум") ?></div>
                                                </div>
                                                <?php if ($order->status == Order::STATUS_SELECTED_PRODUCER) : ?>
                                                    <div class="col">
                                                        <div class="d-doc__title"><?= t("Актуальная цена") ?>:</div>
                                                        <div class="d-doc__text d-doc-text--price fs-24 font-weight-bold">‭<?= showPrice($order->actual_price) ?> <?= t("сум") ?></div>
                                                    </div>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php foreach ($order->orderLists as $index => $order_list) : ?>
                                    <div class="d-doc__brand">
                                        <div class="brand__details mt-10 fs-15">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div id="" class="product-info__gallery  position-relative">
                                                        <div class="item rounded-lg" style="background-image: url('<?= $order_list->product->path ?>')">
                                                            <a href="<?= $order_list->product->originalPath ?>" class="stretched-link gallery-popup-link">
                                                                <i class="icon-maximize" title="Увеличить фото"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <?php foreach ($order_list->product->productImages as $pi) : ?>
                                                            <div class="col-3 mb-4">
                                                                <a href="<?= $pi->originalPath ?>" class="stretched-link gallery-popup-link">
                                                                    <img src="<?= $pi->path ?>" alt="">
                                                                </a>
                                                            </div>
                                                        <?php endforeach ?>
                                                    </div>
                                                    <div class="product-new-description mt-20">
                                                        <h4><?=t("Технические характеристики")?></h4>
                                                        <div class="content">
                                                            <?= $order_list->product->description ?>
                                                        </div>
                                                    </div>
                                                    <div class="brand__details mt-30 fs-15">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="brand__detail mb-20 pl-20">
                                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Статус") ?>:</div>
                                                                    <div class="d-doc__text"><?= $order->statusName ?></div>
                                                                </div>
                                                            </div>
                                                            <?php if ($order->status == Order::STATUS_WAITING_ACCEPT) : ?>
                                                                <div class="col-lg-6">
                                                                    <div class="brand__detail mb-20 pl-20">
                                                                        <div class="d-doc__title fw-semi-bold mb-5"><?= t("Дата окончания удтверждения") ?>:</div>
                                                                        <div class="d-doc__text"><?= $order->request_end ? date("d.m.Y H:i:s", strtotime($order->request_end)) : null ?></div>
                                                                    </div>
                                                                </div>
                                                            <?php elseif ($order->status == Order::STATUS_REQUESTING) : ?>
                                                                <div class="col-lg-6">
                                                                    <div class="brand__detail mb-20 pl-20">
                                                                        <div class="d-doc__title fw-semi-bold mb-5"><?= t("Дата окончания") ?>:</div>
                                                                        <div class="d-doc__text"><?= $order->tender_end ? date("d.m.Y H:i:s", strtotime($order->tender_end)) : null ?></div>
                                                                    </div>
                                                                </div>
                                                            <?php elseif ($order->status == Order::STATUS_SELECTED_PRODUCER) : ?>
                                                                <div class="col-lg-6">
                                                                    <div class="brand__detail mb-20 pl-20">
                                                                        <div class="d-doc__title fw-semi-bold mb-5"><?= t("Дата торга") ?>:</div>
                                                                        <div class="d-doc__text"><?= $order->tender_end ? date("d.m.Y H:i:s", strtotime($order->tender_end)) : null ?></div>
                                                                    </div>
                                                                </div>
                                                            <?php endif ?>

                                                            <?php if ($order->status == Order::STATUS_REQUESTING || $order->status == Order::STATUS_SELECTED_PRODUCER) : ?>
                                                                <div class="col-lg-6">
                                                                    <div class="brand__detail mb-20 pl-20">
                                                                        <div class="d-doc__title fw-semi-bold mb-5"><?= t("Количество приведенных цен") ?>:</div>
                                                                        <div class="d-doc__text"><?= count($order->orderRequests) ?></div>
                                                                    </div>
                                                                </div>
                                                            <?php endif ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="d-doc__title mb-5"> <?= t("№ товара") ?> <?= $order_list->product->id ?></div>
                                                    <div class="d-doc__text">
                                                        <h1 class="new-page-title mb-20"><?= $order_list->product->title ?></h1>
                                                    </div>
                                                    <div class="brand__detail2 mb-10 ">
                                                        <div class="d-doc__title fw-semi-bold mb-5"><?= t("Цена за ед.") ?>:</div>
                                                        <div class="d-doc__text"><?= showPrice($order_list->price) ?> <?= t("сум") ?></div>
                                                    </div>
                                                    <div class="brand__detail2 mb-10 ">
                                                        <div class="d-doc__title fw-semi-bold mb-5"><?= t("Количество") ?>:</div>
                                                        <div class="d-doc__text"><?= $order_list->quantity ?></div>
                                                    </div>
                                                    <div class="brand__detail2 mb-10 ">
                                                        <div class="d-doc__title fw-semi-bold mb-5"><?= t("Сумма") ?>:</div>
                                                        <div class="d-doc__text"><?= showPrice($order_list->price * $order_list->quantity) ?> <?= t("сум") ?></div>
                                                    </div>
                                                    <div class="product-info__brief px-15 mt-20">
                                                        <dl class="row">
                                                            <dt class="col-6 pl-0 odd"><?= t("Гарантийный срок") ?>:</dt>
                                                            <dd class="col-6 pr-0 odd"><?= $order_list->product->warrantyPeriod ?></dd>
                                                            <dt class="col-6 pl-0 even"><?= t("Срок доставки") ?>:</dt>
                                                            <dd class="col-6 pr-0 even"><?= $order_list->product->deliveryPeriod ?></dd>
                                                            <dt class="col-6 pl-0 odd"><?= t("Место доставки") ?>:</dt>
                                                            <dd class="col-6 pr-0 odd"><?= $order_list->product->deliveryRegions ?></dd>
                                                            <dt class="col-6 pl-0 even"><?= t("Категория") ?>:</dt>
                                                            <dd class="col-6 pr-0 even"><?= $order_list->product->ctitle ?></dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>