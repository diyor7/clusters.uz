<?php
/* @var $this yii\web\View */

use frontend\widgets\MyPagination;
use frontend\widgets\Product;

$this->title = t("Все продукты");
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
            <a href="<?= toRoute('/store/category') ?>"><?= t("Электронный магазин") ?></a>
            <span></span>
            <p> <?= $this->title ?></p>
        </div>
    </div>
</div>

<div class="new-bg-different">
    <div class="container py-40">

        <div class="new-filter mb-30">
            <a href="#!" class="new-filter-toggle">
                <h3 class="new-title-5 d-flex align-items-center">
                    <img class="mr-3" src="/img/new-filter.svg" alt="">
                    <span><?= $is_open ? t('Скрыть фильтр') : t("Фильтр") ?></span>
                </h3>
            </a>

            <div class="content <?= $is_open ? 'show' : '' ?>" style="<?= $is_open ? '' : 'display:none' ?>">
                <form action="" class="w-100">
                    <div class="d-flex overflow-hidden">
                        <div class="form-group mb-0 col-4">
                            <label for="a-name"><?= t("Наименование товара или № товара") ?>:</label>
                            <input id="a-name" name="name" value="<?= $name ?>" type="text">
                        </div>
                        <div class="form-group mb-0 col-2">
                            <label for="a-name3"><?= t("Цена") ?>:</label>
                            <input id="a-name3" name="summa_from" value="<?= $summa_from ?>" placeholder="<?= t("от") ?>" type="text">
                        </div>
                        <div class="form-group mb-0 col-2">
                            <label for="a-name4" class="visiblity-hidden"><?= t("Цена") ?>:</label>
                            <input id="a-name4" name="summa_to" value="<?= $summa_to ?>" placeholder="<?= t("до") ?>" type="text">
                        </div>
                        <div class="form-group mb-0 col-4">
                            <label for="a-name5"><?= t("Категория") ?>:</label>
                            <select name="category_id" class="category-ajax w-100" value="<?= $category_id ?>">
                                <?php $cat = \common\models\Category::findOne($category_id); ?>

                                <?php if ($cat) : ?>
                                    <option value="<?= $cat->id ?>"><?= $cat->title ?></option>
                                <?php endif ?>
                            </select>
                        </div>
                    </div>
                    <div class="text-right mt-4">
                        <button class="btn-new"><?=t("Поиск")?></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="all-products">
            <?= t("Все товары") ?>: <?= $count ?>
        </div>

        <div class="mb-30">
            <div class="row mx-n10 mx-xxl-n15">
                <?php foreach ($products as $product) : ?>
                    <?= Product::widget(['product' => $product]) ?>
                <?php endforeach ?>
            </div>
            <?= MyPagination::widget(['pages' => $pages, 'count' => count($products)]) ?>

        </div>
    </div>
</div>

<?php
$this->registerJs('
    $(".new-filter-toggle").click(function (){
        if($(this).closest(".new-filter").find(".content").hasClass("show")){
            $(this).closest(".new-filter").find(".content").slideUp(200);
            $(this).closest(".new-filter").find(".content").removeClass("show");
            $(this).find("span").text("Фильтр");
        } else {
            $(this).closest(".new-filter").find(".content").slideDown(200);
            $(this).closest(".new-filter").find(".content").addClass("show");
            $(this).find("span").text("Скрыть фильтр");
        }
    });
      
    $(".tn-ajax").trigger("change");
    $(".category-ajax").trigger("change");
', 3)
?>