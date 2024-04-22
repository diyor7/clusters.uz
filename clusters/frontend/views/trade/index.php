<?php

use common\models\Order;

$this->title = t("Закупки");

$this->params['breadcrumbs'][] = array(
    'label' => t("Закупки"),
    'url' => toRoute('/trade/index')
);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="container py-30">
        <div class="d-flex align-items-start">
            <div class="mr-20">
                <img src="/img/newplatform2.png" alt="">
            </div>
            <div>
                <h1 class="new-title-4 mb-0 pt-2">
                    <?= $this->title ?>
                </h1>
            </div>
        </div>

        <div class="new-breadcrumbs d-flex align-items-center">
            <a href="<?= toRoute('/') ?>"><?= t("Главная") ?></a>
            <span></span>
            <p><?= $this->title ?></p>
        </div>
    </div>
</div>
<div class="new-bg-different py-30">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="i-list mb-30 ">
                    <div class="i-list__head px-20 mb-20">
                        <div class="row no-gutters">
                            <div class="col-1">
                                <div class="i-list__sortable"><?= t("Номер запроса") ?></div>
                            </div>
                            <div class="col-2 text-center">
                                <div class="i-list__sortable"><?= t("Наименование товара") ?></div>
                            </div>
                            <div class="col-2 text-center">
                                <div class="i-list__sortable"><?= t("Количество") ?></div>
                            </div>
                            <div class="col-2 text-center">
                                <div class="i-list__sortable"><?= t("Стартовая цена за ед.") ?></div>
                            </div>
                            <div class="col-2 text-center">
                                <div class="i-list__sortable"><?= t("Дата запроса и торга") ?></div>
                            </div>
                            <div class="col-2 text-center">
                                <div class="i-list__sortable"> <?= t("Актуальная цена за ед.") ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="i-list__body">
                        <div class="i-list__items">
                            <?php if (count($orders) == 0) : ?>
                                <div class="item shadow bg-white rounded mb-10 wow fadeInUp">
                                    <div class="item__head py-15 px-20 ">
                                        <div class="text-center"><?= t("Ничего не найдено") ?></div>
                                    </div>
                                </div>
                            <?php endif ?>
                            <?php foreach ($orders as $order) : ?>
                                <div class="item shadow bg-white rounded mb-10 wow fadeInUp">
                                    <div class="item__head py-15 px-20 ">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-1">
                                                <a href="<?= toRoute('/trade/view/' . $order->id) ?>" class="item__name"><b>№ <?= $order->id ?></b></a>
                                            </div>
                                            <div class="col-2 text-center">
                                                <?php foreach ($order->orderLists as $order_list) : ?>
                                                    <a href="<?= toRoute('/trade/view/' . $order->id) ?>"><?= $order_list->product->title ?></a>
                                                <?php endforeach ?>
                                            </div>
                                            <?php $quantity = $order->getOrderLists()->sum("quantity"); ?>
                                            <div class="col-2 text-center"><?= $quantity ?> <?= t("шт.") ?></div>
                                            <div class="col-2 text-center"><?= showPrice($order->total_sum / ($quantity != 0 ? $quantity : 1)) ?> <?= t("сум") ?></div>
                                            <div class="col-2 text-center">
                                                <span class="text-success">
                                                    <?= date("d.m.Y H:i", strtotime($order->created_at)) ?>
                                                </span>
                                                /
                                                <span class="text-danger">
                                                    <?= $order->tender_end ? date("d.m.Y H:i", strtotime($order->tender_end)) : "-" ?>
                                                </span>
                                            </div>
                                            <div class="col-2 text-center">
                                                <?= showPrice(($order->actual_price) / $quantity) ?> <?= t("сум") ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <?= \frontend\widgets\MyPagination::widget(['pages' => $pages, 'count' => count($orders)]) ?>
            </div>
        </div>
    </div>
</div>