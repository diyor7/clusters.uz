<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\customer\models\SearchProcurementPlan */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = t('План закупок');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render("../layouts/_nav", [
    'btn_title' => t('Добавить план закупок'),
    'btn_url' => toRoute('/user/procurement-plans/create')
]) ?>

<div class="new-bg-different py-30">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?= $this->render("../layouts/_menu") ?>
            </div>
            <div class="col-md-9">
                <div class="i-list mb-30 mt-10">
                    <div class="i-list__head px-20 mb-20">
                        <div class="row no-gutters">
                            <div class="col-2">
                                <div class="i-list__sortable"><?= t("Год") ?></div>
                            </div>
                            <div class="col text-center">
                                <div class="i-list__sortable"><?= t("Квартал") ?></div>
                            </div>
                            <div class="col-3 text-center">
                                <div class="i-list__sortable"><?= t("Название товара") ?></div>
                            </div>
                            <div class="col-2 text-center">
                                <div class="i-list__sortable"><?= t("Категория") ?></div>
                            </div>
                            <div class="col-2 text-right">
                                <div class="i-list__sortable"><?= t("Объем") ?></div>
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
                                                <?= $model->year ?>
                                            </div>
                                            <div class="col text-center">
                                                <?= $model->activeKvartal() ?>
                                            </div>
                                            <div class="col text-center"><?= $model->title ?></div>
                                            <div class="col-2 text-center">
                                                <?= $model->category ? $model->category->title : "" ?>
                                            </div>
                                            <div class="col-2 text-right">
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
                                                        <th class="text-left"><?= t("Файл") ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        <td><?= $model->functionality ?></td>
                                                        <td><?= $model->technicality ?></td>
                                                        <td>
                                                            <?php if ($model->filename) : ?>
                                                                <a href="<?= siteUrl() . 'uploads/plan/' . $model->filename ?>" class="d-inline-block mb-10" target="_blank"><?= t("Ранее загруженный файл") ?></a>
                                                            <?php endif ?>
                                                        </td>
                                                    </tr>

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
                                                            <?php if (true || $model->created_at + 24 * 3600 >= time()) : ?>
                                                                <a href="<?= toRoute(['/user/procurement-plans/update', 'id' => $model->id]) ?>" class="btn btn-secondary"><?= t("Изменить") ?></a>
                                                            <?php endif ?>
                                                            <a href="<?= toRoute(['/user/procurement-plans/delete', 'id' => $model->id]) ?>" class="btn btn-danger" data-method="POST" data-confirm="<?=t("Вы уверены?")?>"><?= t("Удалить") ?></a>

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
        </div>
    </div>
</div>