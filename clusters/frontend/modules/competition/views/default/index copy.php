<?php

$this->title = $title;

$this->params['breadcrumbs'][] = array(
    'label' => $this->title,
    'url' => toRoute('/auction')
);
$this->params['breadcrumbs'][] = $this->title;
?>

<?= '';//$this->render("../layouts/_menu") ?>

<div class="new-bg-different">
    <div class="container py-30">
        <div class="d-flex align-items-start">
            <div class="mr-20">
                <img src="/img/newplatform3.png" alt="">
            </div>
            <div>
                <h1 class="new-title-4 mb-0 pt-2">
                    <?= $this->title ?>
                </h1>
            </div>
        </div>

        <div class="new-breadcrumbs d-flex align-items-center">
            <a href="<?=toRoute('/')?>">Главная</a>
            <span></span>
            <p><?= $this->title ?></p>
        </div>
    </div>
</div>


<div class="container-fluid bg-white pt-40 mh-30">
    <div class="i-list mb-30 mt-n10">
        <div class="i-list__head px-20 mb-20">
            <div class="row no-gutters">
                <div class="col-2">
                    <div class="i-list__sortable"><?= t("Номер лота") ?></div>
                </div>
                <div class="col text-center">
                    <div class="i-list__sortable"><?= t("Дата окончания") ?></div>
                </div>
                <div class="col-3 text-center">
                    <div class="i-list__sortable"><?= t("Категория") ?></div>
                </div>
                <div class="col-2 text-center">
                    <div class="i-list__sortable"><?= t("Стартовая цена") ?></div>
                </div>
                <div class="col-2 text-center">
                    <div class="i-list__sortable"><?= t("Текущая цена") ?></div>
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
                                    <a href="<?= toRoute('/auction/view/' . $model->id) ?>" class="item__name"><b>№ <?= $model->id ?></b></a>
                                </div>
                                <div class="col text-center">
                                    <?= $model->auction_end ? date("d.m.Y H:i:s", strtotime($model->auction_end)) : null ?>
                                </div>
                                <div class="col-3 text-center"><?= $model->category->title ?></div>
                                <div class="col-2 text-center"><?= showPrice($model->total_sum) ?> <?= t("сум") ?></div>
                                <div class="col-2 text-center">
                                    <?= showPrice($model->currentPrice) ?>
                                </div>
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
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th><?= t("Товар") ?></th>
                                            <th class="text-center"><?= t("Количество") ?></th>
                                            <th class="text-center"><?= t("Цена") ?></th>
                                            <th class="text-right"><?= t("Сумма") ?></th>
                                            <th class="text-right"><?= t("Описание") ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($model->auctionTns as $index => $model_list) : ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= $model_list->tn->title ?></td>
                                                <td class="text-center"><?= $model_list->quantity ?></td>
                                                <td class="text-center whitespace-nowrap"><?= showPrice($model_list->price) ?> <?= t("сум") ?></td>
                                                <td class="text-right whitespace-nowrap"><?= showPrice($model_list->quantity * $model_list->price) ?> <?= t("сум") ?></td>
                                                <td class="text-right"><?= ($model_list->description) ?> </td>
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
                                                <a class="btn btn-link d-inline-flex align-items-center collapsed" data-toggle="collapse" data-target="#itemId-<?= $model->id ?>" role="button" aria-expanded="false" aria-controls="itemId-<?= $model->id ?>">
                                                    <?= t("Скрыть доп. инфо") ?> <i class="icon-chevron-up font-weight-bold fs-16 ml-5"></i>
                                                </a>
                                                <a href="<?= toRoute('/auction/view/' . $model->id) ?>" class="btn btn-primary px-20 py-5 fs-15 mr-5"><?= t("Посмотреть") ?></a>
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
    <?= \frontend\widgets\MyPagination::widget(['pages' => $pages, 'count' => count($models)]) ?>
</div>