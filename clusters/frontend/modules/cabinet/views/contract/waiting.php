<?php

use common\models\Contract;

$this->title = t("Договоры");

$this->params['breadcrumbs'][] = array(
    'label' => t("Личный кабинет"),
    'url' => toRoute('/cabinet')
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
                    <!-- <li class="nav-item position-relative  pb-30 mr-15">
                        <a class="nav-link  p-0" href="<?= toRoute('/' . Yii::$app->controller->module->id . '/contract') ?>">
                            <?= t("Оформленные договоры") ?> (<?= isset($counts[Contract::STATUS_CREATED]) ? $counts[Contract::STATUS_CREATED] + 0 : 0 ?>)
                        </a>
                    </li> -->
                    <li class="nav-item position-relative  pb-30 mx-15">
                        <a class="nav-link p-0 active" href="<?= toRoute('/' . Yii::$app->controller->module->id . '/contract/waiting') ?>">
                            <?= t("Заключенные") ?> (<?= isset($counts[Contract::STATUS_WAITING_PAYMENT_FROM_CUSTOMER]) ? $counts[Contract::STATUS_WAITING_PAYMENT_FROM_CUSTOMER] + 0 : 0 ?>)
                        </a>
                    </li>
                    <li class="nav-item position-relative  pb-30 mx-15">
                        <a class="nav-link p-0 " href="<?= toRoute('/' . Yii::$app->controller->module->id . '/contract/processing') ?>">
                            <?= t("На выполнение") ?> (<?= isset($counts[Contract::STATUS_PROCESSING]) ? $counts[Contract::STATUS_PROCESSING] + 0 : 0 ?>)
                        </a>
                    </li>
                    <li class="nav-item position-relative  pb-30 mx-15">
                        <a class="nav-link p-0 " href="<?= toRoute('/' . Yii::$app->controller->module->id . '/contract/delivered') ?>">
                            <?= t("Выполненный") ?> (<?= isset($counts[Contract::STATUS_DELIVERED]) ? $counts[Contract::STATUS_DELIVERED] + 0 : 0 ?>)
                        </a>
                    </li>
                    <li class="nav-item position-relative  pb-30 mx-15">
                        <a class="nav-link p-0 " href="<?= toRoute('/' . Yii::$app->controller->module->id . '/contract/cancelled') ?>">
                            <?= t("Расторженные") ?> (<?= isset($counts[Contract::STATUS_CANCELLED]) ? $counts[Contract::STATUS_CANCELLED] + 0 : 0 ?>)
                        </a>
                    </li>
                </ul>
                <div class="i-list mb-30 mt-10">
                    <div class="i-list__head px-20 mb-20">
                        <div class="row no-gutters">
                            <div class="col-2">
                                <div class="i-list__sortable"><?= t("Номер и дата запроса") ?></div>
                            </div>
                            <div class="col text-center">
                                <div class="i-list__sortable"><?= t("Заказчик") ?></div>
                            </div>
                            <div class="col-2 text-center">
                                <div class="i-list__sortable"><?= t("Тип доставки") ?></div>
                            </div>
                            <div class="col-2 text-center">
                                <div class="i-list__sortable"><?= t("Статус") ?></div>
                            </div>
                            <div class="col-2 text-center">
                                <div class="i-list__sortable"><?= t("Сумма") ?></div>
                            </div>
                            <div class="col-auto" style="width: 35px;"></div>
                        </div>
                    </div>
                    <div class="i-list__body">
                        <div class="i-list__items">
                            <?php if (count($models) == 0) : ?>
                                <div class="item shadow bg-white rounded mb-10 wow fadeInUp">
                                    <div class="item__head py-15 px-20 ">
                                        <div class="text-center"><?= t("Ничего не найдено") ?></div>
                                    </div>
                                </div>
                            <?php endif ?>
                            <?php foreach ($models as $model) : ?>
                                <div class="item shadow bg-white rounded mb-10 wow fadeInUp">
                                    <div class="item__head py-15 px-20 ">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-2">
                                                <a href="<?= toRoute('/' . Yii::$app->controller->module->id . '/contract/' . $model->id) ?>" class="item__name"><b>№ <?= $model->id ?></b> / <span><?= date("d.m.Y H:i", strtotime($model->created_at)) ?></span></a>
                                            </div>
                                            <div class="col text-center">
                                                <?= $model->customer->name ?>
                                            </div>
                                            <div class="col-2 text-center"><?= $model->order ? $model->order->deliveryType : $model->auction->region->title . ' ' . $model->auction->address?></div>
                                            <div class="col-2 text-center">
                                                <span class="item__badge <?= $model->statusClass ?> d-inline-block"><?= $model->statusName ?></span>
                                                <span class="mt-5 d-block fs-14">

                                                </span>
                                            </div>
                                            <div class="col-2 text-center"><?= showPrice($model->price) ?> <?= t("сум") ?></div>
                                            <div class="col-auto pl-15">
                                                <div class="item__icon collapsed" data-toggle="collapse" data-target="#itemId-<?= $model->id ?>" role="button" aria-expanded="false" aria-controls="itemId-<?= $model->id ?>">
                                                    <i class="icon-chevron-down align-middle"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse multi-collapse" id="itemId-<?= $model->id ?>">
                                        <div class="item__body fs-15 py-20 mx-20 ">
                                            <div class="fs-14 fw-semi-bold mb-20 text-uppercase"><?= t("Продукты заказа") ?>:</div>
                                            <table class="table mb-0">
                                                <?php if($model->order): ?>
                                                    <thead>
                                                        <tr>
                                                            <th>№</th>
                                                            <th><?= t("Товар") ?></th>
                                                            <th class="text-center"><?=t("Код ТН ВЭД")?></th>
                                                            <th class="text-center"><?= t("Количество") ?></th>
                                                            <th class="text-center"><?= t("Предложенная цена") ?></th>
                                                            <th class="text-right"><?= t("Сумма") ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($model->order->orderLists as $index => $model_list) : ?>
                                                            <tr>
                                                                <td><?= $index + 1 ?></td>
                                                                <td><?= $model_list->product->title ?></td>
                                                                <td class="text-center"><?= $model_list->product->code ?></td>
                                                                <td class="text-center"><?= $model_list->quantity ?></td>
                                                                <td class="text-center"><?= showPrice($model->order->winner->price) ?> <?= t("сум") ?></td>
                                                                <td class="text-right"><?= showPrice($model_list->quantity * $model->order->winner->price) ?> <?= t("сум") ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                <?php elseif($model->auction):?>

                                                    <thead>
                                                        <tr>
                                                            <th>№</th>
                                                            <th><?= t("Товар") ?></th>
                                                            <th class="text-center"><?=t("№ ЛОТА")?></th>
                                                            <th class="text-center"><?= t("Количество товара") ?></th>
                                                            <th class="text-center"><?= t("Предложенная цена") ?></th>
                                                            <th class="text-right"><?= t("Сумма") ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($model->auction->auctionCategories as $index => $auctionCategory) : ?>
                                                            <tr>
                                                                <td><?= $index + 1 ?></td>
                                                                <td><?= $auctionCategory->category->title ?></td>
                                                                <td class="text-center"><?= $model->auction_id ?></td>
                                                                <td class="text-center"><?= showQuantity($auctionCategory->quantity) ?> <?= $auctionCategory->unit->title ?></td>
                                                                <td class="text-center"><?= showPrice($auctionCategory->price * ($model->auction->currentPrice / $model->auction->total_sum)) ?> <?= t("сум") ?></td>
                                                                <td class="text-right"><?= showPrice($model->auction->currentPrice) ?> <?= t("сум") ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                <?php endif; ?>

                                            </table>
                                        </div>
                                        <div class="item__footer bg-gray py-15">
                                            <div class="container-fluid">
                                                <div class="row align-items-center">
                                        
                                                    <div class="col text-right">
                                                        <div class="collapse-btns">
                                                            <a class="btn btn-link d-inline-flex align-items-center collapsed" data-toggle="collapse" data-target="#itemId-<?= $model->id ?>" role="button" aria-expanded="false" aria-controls="itemId-<?= $model->id ?>">
                                                                <?= t("Скрыть доп. инфо") ?> <i class="icon-chevron-up font-weight-bold fs-16 ml-5"></i>
                                                            </a>
                                                            <a href="<?= toRoute('/' . Yii::$app->controller->module->id . '/contract/' . $model->id) ?>" class="btn btn-primary px-20 py-5 fs-15 mr-5"><?= t("Посмотреть") ?></a>

                                                            <a class="btn btn-danger px-20 py-5 fs-15" data-sign="true" data-tin="<?= $model->producer->tin ?>" data-confirm="<?= t("Вы точно хотите расторгнуть?") ?>" href="<?= toRoute('/' . Yii::$app->controller->module->id . '/contract/cancel?id=' . $model->id) ?>"><?= t("Расторгнуть") ?></a>
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
            </div>
        </div>
    </div>
</div>