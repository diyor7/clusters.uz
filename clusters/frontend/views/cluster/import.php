<?php

use frontend\widgets\MyPagination;
use chillerlan\QRCode\QRCode;

$this->title =  t("Импорт");
?>

<div class="bg-white">
    <div class="container py-30">
        <div class="d-flex align-items-start">
            <div class="mr-20">
                <img src="/img/newplatform1.png" alt="">
            </div>
            <div>
                <h1 class="new-title-4 pt-2">
                    <?= $this->title ?>
                </h1>
            </div>
        </div>

        <div class="new-breadcrumbs d-flex align-items-center">
            <a href="<?= toRoute('/') ?>"><?= t("Главная") ?></a>
            <span></span>
            <a href="<?= toRoute('/cluster/' . $data['cluster']) ?>"><?= $data['title'] ?></a>
            <span></span>
            <p><?= $this->title ?></p>
        </div>
    </div>
</div>

<div class="new-bg-different">
    <div class="container py-40">
        <div class="mb-30">
            <div class="i-list mb-30 mt-10">
                <div class="i-list__head px-20 mb-20">
                    <div class="row no-gutters">
                        <div class="col-3 text-center">
                            <div class="i-list__sortable"><?= t("Название товара") ?></div>
                        </div>
                        <div class="col text-center">
                            <div class="i-list__sortable"><?= t("Файл") ?></div>
                        </div>
                        <div class="col text-center">
                            <div class="i-list__sortable"><?= t("Дата") ?></div>
                        </div>
                        <div class="col text-center">
                            <div class="i-list__sortable"><?= t("Категория") ?></div>
                        </div>
                        <div class="col text-right">
                            <div class="i-list__sortable"><?= t("Объем") ?></div>
                        </div>

                        <div class="col-auto" style="width: 35px;"></div>
                    </div>
                </div>
                <div class="i-list__body">
                    <div class="i-list__items">
                        <?php if (count($plans) == 0) : ?>
                            <div class="item shadow bg-white rounded mb-10 wow fadeInUp">
                                <div class="item__head py-15 px-20 ">
                                    <div class="text-center"><?= t("Ничего не найдено") ?></div>
                                </div>
                            </div>
                        <?php endif ?>
                        <?php foreach ($plans as $model) : ?>
                            <div class="item shadow bg-white rounded mb-10 wow fadeInUp">
                                <div class="item__head py-15 px-20 ">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-3 text-center">
                                            <a href="<?= toRoute('/cluster/' . $data['cluster'] . '/import/' . $model->id) ?>">
                                                <b><?= $model->title ?></b>
                                            </a>
                                        </div>
                                        <div class="col text-center">
                                            <?php if ($model->filename && (endsWith($model->filename, "png") || endsWith($model->filename, "jpg") || endsWith($model->filename, "jpeg"))) : ?>
                                                <img style="max-height: 80px" src="<?= siteUrl() . 'uploads/plan/' . $model->filename ?>">
                                            <?php elseif ($model->filename) : ?>
                                                <a href="<?= siteUrl() . 'uploads/plan/' . $model->filename ?>" class="d-inline-block mb-10" target="_blank"><?= t("Файл") ?></a>
                                            <?php endif ?>
                                        </div>
                                        <div class="col text-center">
                                            <?= $model->year ?>
                                            <?= $model->activeKvartal() ?>
                                        </div>
                                        <div class="col text-center">
                                            <?= $model->category ? $model->category->title : "" ?>
                                        </div>
                                        <div class="col text-right">
                                            <?= $model->unit_val . ' ' . $model->unit->title ?>
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
                                        <div class="fs-14 fw-semi-bold mb-20 text-uppercase"><?= t("Подробнее") ?>:</div>
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th><?= t("Функциональность") ?></th>
                                                    <th class="text-left"><?= t("Технические характеристики") ?></th>
                                                    <th class="text-center"><?= t("Ссылка") ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?= $model->functionality ?></td>
                                                    <td><?= $model->technicality ?></td>
                                                    <td class="text-center">
                                                        <?php
                                                        $d = 'http://clusters.uz' . toRoute('/cluster/' . $data['cluster'] . '/import/' . $model->id);
                                                        echo '<img style="width: 100px" src="' . (new QRCode())->render($d) . '" alt="QR Code" />';
                                                        ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
            <?= MyPagination::widget(['pages' => $pages, 'count' => count($plans)]) ?>
        </div>
    </div>
</div>