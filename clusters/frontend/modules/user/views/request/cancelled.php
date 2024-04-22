<?php

use common\models\Order;

$this->title = t("Запросы цен");

$this->params['breadcrumbs'][] = array(
    'label' => t("Личный кабинет"),
    'url' => toRoute('/user')
);
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render("../layouts/_nav") ?>

<div class="new-bg-different py-30">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?= $this->render("../layouts/_menu") ?>
            </div>
            <div class="col-md-9">
                <ul class="nav nav-cabinet fs-15">
                    <li class="nav-item position-relative pb-30 mr-15">
                        <a class="nav-link p-0" href="<?= toRoute('/user/request/waiting') ?>">
                            <?= t("Ожидается подтверждения") ?> (<?= isset($counts[Order::STATUS_WAITING_ACCEPT]) ? $counts[Order::STATUS_WAITING_ACCEPT] + 0 : 0 ?>)
                        </a>
                    </li>
                    <li class="nav-item position-relative pb-30 mx-15">
                        <a class="nav-link p-0 " href="<?= toRoute('/user/request') ?>">
                            <?= t("Активные запросы") ?> (<?= isset($counts[Order::STATUS_REQUESTING]) ? $counts[Order::STATUS_REQUESTING] + 0 : 0 ?>)
                        </a>
                    </li>
                    <li class="nav-item position-relative pb-30 mx-15">
                        <a class="nav-link p-0 " href="<?= toRoute('/user/request/finished') ?>">
                            <?= t("Завершенные") ?> (<?= isset($counts[Order::STATUS_SELECTED_PRODUCER]) ? $counts[Order::STATUS_SELECTED_PRODUCER] + 0 : 0 ?>)
                        </a>
                    </li>
                    <li class="nav-item position-relative pb-30 mx-15">
                        <a class="nav-link p-0 active" href="<?= toRoute('/user/request/cancelled') ?>">
                            <?= t("Отказанные") ?> (<?= isset($counts[Order::STATUS_CANCELLED_FROM_PRODUCER]) ? $counts[Order::STATUS_CANCELLED_FROM_PRODUCER] + 0 : 0  ?>)
                        </a>
                    </li>
                </ul>

                <div class="i-list mb-30 mt-10">
                    <div class="i-list__head px-20 mb-20">
                        <div class="row no-gutters">
                            <div class="col-2">
                                <div class="i-list__sortable"><?= t("Номер и дата запроса") ?></div>
                            </div>
                            <div class="col-3 text-center">
                                <div class="i-list__sortable"><?= t("Наименование товара") ?></div>
                            </div>
                            <div class="col-2 text-center">
                                <div class="i-list__sortable"><?= t("Количество") ?></div>
                            </div>
                            <div class="col-2 text-center">
                                <div class="i-list__sortable"><?= t("Стартовая цена за ед.") ?></div>
                            </div>
                            <div class="col-2 text-center">
                                <div class="i-list__sortable"><?= t("Дата отказа") ?></div>
                            </div>
                            <div class="col-1" style="width: 35px;"></div>
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
                                            <div class="col-2">
                                                <a href="<?= toRoute('/user/request/' . $order->id) ?>" class="item__name"><b>№ <?= $order->id ?></b> / <span><?= date("d.m.Y H:i", strtotime($order->created_at)) ?></span></a>
                                            </div>
                                            <div class="col-3 text-center">
                                                <?php foreach ($order->orderLists as $index => $order_list) : ?>
                                                    <a href="<?= toRoute('/user/request/' . $order->id) ?>"><?= $order_list->product->title ?></a>
                                                <?php endforeach ?>
                                            </div>

                                            <?php $quantity = $order->getOrderLists()->sum("quantity"); ?>
                                            <div class="col-2 text-center"><?= $quantity ?> <?= t("шт.") ?></div>
                                            <div class="col-2 text-center"><?= showPrice($order->total_sum / ($quantity != 0 ? $quantity : 1)) ?> <?= t("сум") ?></div>
                                            <div class="col-2 text-center">
                                                <span class="text-danger">
                                                    <?= $order->cancel_date ? date("d.m.Y H:i:s", strtotime($order->cancel_date)) : date("d.m.Y H:i", strtotime($order->request_end)) ?>
                                                </span>
                                            </div>
                                            <div class="col-1 pl-15">
                                                <div class="item__icon collapsed text-right" data-toggle="collapse" data-target="#itemId-<?= $order->id ?>" role="button" aria-expanded="false" aria-controls="itemId-<?= $order->id ?>">
                                                    <i class="icon-chevron-down align-middle"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse multi-collapse" id="itemId-<?= $order->id ?>">
                                        <div class="item__body fs-15 py-20 mx-20 ">
                                            <div class="fs-14 fw-semi-bold mb-20 text-uppercase"><?= t("Продукты заказа") ?>:</div>
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>№</th>
                                                        <th><?= t("Товар") ?></th>
                                                        <th class="text-center"><?=t("Категория")?></th>
                                                        <th class="text-center"><?= t("Количество") ?></th>
                                                        <th class="text-center"><?= t("Цена") ?></th>
                                                        <th class="text-right"><?= t("Сумма") ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($order->orderLists as $index => $order_list) : ?>
                                                        <tr>
                                                            <td><?= $index + 1 ?></td>
                                                            <td><?= $order_list->product->title ?></td>
                                                            <td class="text-center"><?= $order_list->product->ctitle ?></td>
                                                            <td class="text-center"><?= $order_list->quantity ?></td>
                                                            <td class="text-center"><?= showPrice($order_list->price) ?> <?= t("сум") ?></td>
                                                            <td class="text-right"><?= showPrice($order_list->quantity * $order_list->price) ?> <?= t("сум") ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="item__footer bg-gray py-15">
                                            <div class="container-fluid">
                                                <div class="row align-items-center">
                                                    <div class="col">

                                                    </div>
                                                    <div class="col text-right">
                                                        <div class="collapse-btns">
                                                            <a class="btn btn-link d-inline-flex align-items-center collapsed" data-toggle="collapse" data-target="#itemId-<?= $order->id ?>" role="button" aria-expanded="false" aria-controls="itemId-<?= $order->id ?>">
                                                                <?= t("Скрыть доп. инфо") ?> <i class="icon-chevron-up font-weight-bold fs-16 ml-5"></i>
                                                            </a>
                                                            <a href="<?= toRoute('/user/request/' . $order->id) ?>" class="btn btn-primary px-20 py-5 fs-15 mr-5"><?= t("Посмотреть") ?></a>
                                                        </div>
                                                    </div>
                                                </div>
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