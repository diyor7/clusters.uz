<?php

use common\models\Region;
use yii\bootstrap\Html;

$this->title = $title;

$this->params['breadcrumbs'][] = array(
    'label' => $this->title,
    'url' => toRoute('/auction')
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
                <div class="new-filter w-100">
                    <a href="#!" class="new-filter-toggle">
                        <h3 class="new-title-5 d-flex align-items-center">
                            <img class="mr-3" src="/img/new-filter.svg" alt="">
                            <span><?= $is_open ? t('Скрыть фильтр') : t("Фильтр") ?></span>
                        </h3>
                    </a>
                    <div class="content <?= $is_open ? 'show' : '' ?>" style="<?= $is_open ? '' : 'display:none' ?>">
                        <form action="" class="w-100">
                            <div class="d-flex flex-wrap">
                                <div class="form-group mb-15 mr-25 flex-grow-1">
                                    <label for="a-name"><?=t("Наименование товара или № лота")?>:</label>
                                    <input id="a-name" name="name" value="<?= $name ?>" type="text">
                                </div>
                                <div class="form-group mb-15 mr-25">
                                    <label for="a-name2"><?=t("Регион")?>:</label>
                                    <?= Html::dropDownList('region_id', $region_id, Region::getTree(), ['prompt' => t("Выберите регион"), 'id' => 'a-name2']) ?>
                                </div>
                                <div class="form-group mb-15 mr-25 px-0">
                                    <label for="a-name5"><?=t("Товар")?>:</label>
                                    <select name="tovar_id" class="category-ajax w-100" value="<?= $tovar_id ?>">
                                        <?php $category = \common\models\Category::findOne($tovar_id); ?>

                                        <?php if ($category) : ?>
                                        <option value="<?= $category->id ?>"><?= $category->title ?></option>
                                        <?php endif ?>
                                    </select>
                                </div>
                                <div class="form-group mb-15 mr-25">
                                    <label for="a-name3"><?=t("Сумма")?>:</label>
                                    <input id="a-name3" name="summa_from" value="<?= $summa_from ?>"
                                        placeholder="<?=t("от")?>" type="text">
                                </div>
                                <div class="form-group mb-15 mr-25">
                                    <label for="a-name4" class="visiblity-hidden"><?=t("Сумма")?>:</label>
                                    <input id="a-name4" name="summa_to" value="<?= $summa_to ?>"
                                        placeholder="<?=t("до")?>" type="text">
                                </div>

                                <div class="form-group mb-15">
                                    <label for="a-name6"><?=t("Дата окончания:")?></label>
                                    <input id="a-name6" name="auction_end" value="<?= $auction_end ?>" type="date">
                                </div>
                            </div>
                            <div class="text-right mt-4">
                                <button class="btn-new"><?=t("Поиск")?></button>
                            </div>
                        </form>
                    </div>
                </div>

                <table class="new-table my-35 bg-white">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th><?= t("Номер лота") ?></th>
                            <th><?= t("Дата окончания") ?></th>
                            <th><?= t("Регион") ?></th>
                            <th style="width: 350px;"><?= t("Категория") ?></th>
                            <th><?= t("Стартовая сумма") ?></th>
                            <th><?= t("Текущая сумма") ?></th>
                            <th><?= t("Кол-во запросов") ?></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (count($models) == 0) : ?>
                        <tr class="cursor-default">
                            <td colspan="9"><?= t("Ничего не найдено") ?></td>
                        </tr>
                        <?php endif ?>
                        <?php foreach ($models as $index => $model) : ?>
                        <tr class="bg-white">
                            <td>
                                <?= $index + 1 ?>
                            </td>
                            <td>
                                <b><?= $model->id ?></b>
                            </td>
                            <td>
                                <?= strftime("%d.%m.%Y %H:%M:%S", strtotime($model->auction_end)) ?>
                            </td>
                            <td>
                                <?= $model->region->title ?>
                            </td>
                            <td>
                                <span>
                                    <?=$model->category->title?>
                                </span>
                            </td>
                            <td>
                                <span class="red"><?= showPrice($model->total_sum) ?> <?= t("сум") ?></span>
                            </td>
                            <td>
                                <span class="green"><?= showPrice($model->currentPrice) . ' ' .  t("сум") ?> </span>
                            </td>
                            <td>
                                <?= count($model->auctionRequests) + 0 ?>
                            </td>
                            <td>
                                <div class="item__icon collapsed text-right" data-toggle="collapse"
                                    data-target="#itemId-<?= $model->id ?>" role="button" aria-expanded="false"
                                    aria-controls="itemId-<?= $model->id ?>">
                                    <i class="icon-chevron-down align-middle"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan='9' class="p-0">
                                <div class="collapse multi-collapse" id="itemId-<?= $model->id ?>">
                                    <div class="item__body fs-15 py-20 mx-20 text-left">
                                        <div class="fs-14 fw-semi-bold mb-20 text-uppercase">
                                            <?= t("Информация") ?>:
                                        </div>
                                        <table class="new-table my-35 bg-white">
                                            <thead>
                                                <tr>
                                                    <th>№</th>
                                                    <th style="width: 350px;"><?= t("Название товара") ?></th>
                                                    <th><?= t("Кол-во продуктов") ?></th>
                                                    <th><?= t("Информация") ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($model->auctionCategories as $index => $model_list) : ?>
                                                <tr class="bg-white">
                                                    <td>
                                                        <?= $index + 1 ?>
                                                    </td>
                                                    <td>
                                                        <span class="mr-2"><?= $model_list->category->title ?></span>
                                                    </td>
                                                    <td>
                                                        <b><?= $model_list->quantity . ' ' . $model_list->unit->title?></b>
                                                    </td>
                                                    <td>
                                                        <b><?= $model_list->description ?></b>
                                                    </td>


                                                </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="item__footer bg-gray py-15">
                                        <div class="container-fluid">
                                            <div class="row align-items-center justify-content-end">
                                                <div class="text-right">
                                                    <div class="collapse-btns">
                                                        <a class="btn btn-link d-inline-flex align-items-center collapsed"
                                                            data-toggle="collapse"
                                                            data-target="#itemId-<?= $model->id ?>" role="button"
                                                            aria-expanded="false"
                                                            aria-controls="itemId-<?= $model->id ?>">
                                                            <?= t("Скрыть доп. инфо") ?> <i
                                                                class="icon-chevron-up font-weight-bold fs-16 ml-5"></i>
                                                        </a>
                                                        <a href="<?= toRoute('/auction/view/' . $model->id) ?>"
                                                            class="btn btn-primary px-20 py-5 fs-15 mr-5"><?= t("Посмотреть") ?></a>
                                                        <a href="<?= toRoute('/user/auction/update/' . $model->id) ?>"
                                                            class="btn btn-secondary px-20 py-5 fs-15 mr-5"><?= t("Редактировать") ?></a>
                                                        <a href="<?= toRoute('/user/auction/delete/' . $model->id) ?>"
                                                            class="btn btn-danger px-20 py-5 fs-15 mr-5"
                                                            data-method="<?=t("Вы уверены ?")?>"><?= t("Удалить") ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>

                <?= \frontend\widgets\MyPagination::widget(['pages' => $pages, 'count' => count($models)]) ?>

            </div>
        </div>
    </div>
</div>
</div>

<?php
$this->registerJs('
    $(".new-filter-toggle").click(function (){
        if($(this).closest(".new-filter").find(".content").hasClass("show")){
            $(this).closest(".new-filter").find(".content").slideUp(200);
            $(this).closest(".new-filter").find(".content").removeClass("show");
            $(this).find("span").text("' . t('Фильтр') . '");
        } else {
            $(this).closest(".new-filter").find(".content").slideDown(200);
            $(this).closest(".new-filter").find(".content").addClass("show");
            $(this).find("span").text("' . t('Скрыть фильтр') . '");
        }
    });
    $(".tn-ajax").select2({
        ajax: {
          url: "/site/tns",
          dataType: "json",
          data: function (data) {
                return {
                    query: data.term
                };
            },
        },
        width: "100%",
        language: "ru",
        minimumInputLength: 3
      });
', 3)
?>