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

        <div class="new-filter">
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
                            <label for="a-name"><?=t('Наименование товара или № лота')?>:</label>
                            <input id="a-name" name="name" value="<?= $name ?>" type="text">
                        </div>
                        <div class="form-group mb-15 mr-25">
                            <label for="a-name2"><?=t('Регион')?>:</label>
                            <?= Html::dropDownList('region_id', $region_id, Region::getTree(), ['prompt' => "Выберите регион", 'id' => 'a-name2']) ?>
                        </div>
                        <div class="form-group mb-15 mr-25">
                            <label for="a-name3"><?=t('Сумма')?>:</label>
                            <input id="a-name3" name="summa_from" value="<?= $summa_from ?>" placeholder="<?=t('от')?>" type="text">
                        </div>
                        <div class="form-group mb-15 mr-25">
                            <label for="a-name4" class="visiblity-hidden"><?=t('Сумма')?>:</label>
                            <input id="a-name4" name="summa_to" value="<?= $summa_to ?>" placeholder="<?=t('до')?>" type="text">
                        </div>
                        <div class="form-group mb-15 col-2 mr-25 px-0">
                            <label for="a-name5"><?=t('Товар')?>:</label>
                            <select name="tovar_id" class="category-ajax w-100" value="<?= $tovar_id ?>">
                                <?php $category = \common\models\Category::findOne($tovar_id); ?>

                                <?php if ($category) : ?>
                                    <option value="<?= $category->id ?>"><?= $category->title ?></option>
                                <?php endif ?>
                            </select>
                        </div>
                        <div class="form-group mb-15">
                            <label for="a-name6"><?=t('Дата окончания')?>:</label>
                            <input id="a-name6" name="auction_end" value="<?= $auction_end ?>" type="date">
                        </div>
                    </div>
                    <div class="text-right mt-4">
                        <button class="btn-new"><?=t('Поиск')?></button>
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
                    <th style="width: 350px;"><?= t("Название товара") ?></th>
                    <th><?= t("Стартовая сумма") ?></th>
                    <th><?= t("Текущая сумма") ?></th>
                    <th><?= t("Кол-во запросов") ?></th>
                </tr>
            </thead>

            <tbody>
                <?php if (count($models) == 0) : ?>
                    <tr class="cursor-default">
                        <td colspan="8"><?= t("Ничего не найдено") ?></td>
                    </tr>
                <?php endif ?>
                <?php foreach ($models as $index => $model) : ?>
                    <tr class="bg-white" onclick="document.location.href = '<?= toRoute('/auction/view/' . $model->id) ?>'">
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
                            <?php foreach ($model->auctionCategories as $index => $model_list) : ?>
                                <span class="mr-2"><?= $model_list->category->title ?><?= $index != count($model->auctionCategories) - 1 ? ', ' : '' ?></span>
                            <?php endforeach ?>
                        </td>
                        <td>
                            <span class="red"><?= showPrice($model->total_sum) ?> <?= t("сум") ?></span>
                        </td>
                        <td>
                            <span class="green"><?= showPrice($model->currentPrice) ?></span>
                        </td>
                        <td>
                            <?= count($model->auctionRequests) + 0 ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <?= \frontend\widgets\MyPagination::widget(['pages' => $pages, 'count' => count($models)]) ?>
    </div>
</div>
</div>

<?php
$this->registerJs('
    $(".new-filter-toggle").click(function (){
        if($(this).closest(".new-filter").find(".content").hasClass("show")){
            $(this).closest(".new-filter").find(".content").slideUp(200);
            $(this).closest(".new-filter").find(".content").removeClass("show");
            $(this).find("span").text("' . t("Фильтр") . '");
        } else {
            $(this).closest(".new-filter").find(".content").slideDown(200);
            $(this).closest(".new-filter").find(".content").addClass("show");
            $(this).find("span").text("' . t('Скрыть фильтр') .'");
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