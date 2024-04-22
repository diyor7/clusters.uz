<?php

use common\models\Category;

$this->title = $category->title;

if ($category->parent)
    $this->params['breadcrumbs'][] = array(
        'label' => $category->parent->title,
        'url' => toRoute('/' . $category->parent->url)
    );

$this->params['breadcrumbs'][] = $this->title;

$categories = Category::getProductsWithCount();

?>
<main>
    <div class="page-head pt-40 pb-30">
        <div class="container-fluid">
            <h1 class="page-title mb-30"><?= $this->title ?></h1>
            <div class="sub-categories">
                <div class="row">
                    <?php if (count($children) > 0) : ?>
                        <div class="col-6 col-xxl-4 mb-20">
                            <div class="sub-category mr-xxl-30">
                                <a class="d-inline-block <?= $parent->id == $category->id ? 'active' : '' ?>" href="<?= toRoute('/' . $parent->url) ?>"><?= t("Все") ?></a>
                            </div>
                        </div>
                        <?php foreach ($children as $child) : ?>
                            <div class="col-6 col-xxl-4 mb-20">
                                <div class="sub-category mr-xxl-30">
                                    <a class="d-inline-block <?= $child->id == $category->id ? 'active' : '' ?>" href="<?= toRoute('/' . $child->url) ?>"><?= $child->title ?></a>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

    <div class="filter mb-30 shadow position-relative">
        <div class="bg-gray py-xl-20">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="d-flex1 align-items-center">
                            <div class="filtered-by1 d-flex1 align-items-center1">
                                <form id="SearchForm" action="<?= toRoute('/' . $parent->url) ?>" method="get" style="margin-bottom:0;">
                                    <div class="row">
                                        <div class="col-7">
                                            <input type="text" class="search__input form-control" name="query" placeholder="Введите номер или наименование продукта..." value="<?=$query?>">
                                        </div>
                                        <div class="col-3">
                                            <select class="js-select form-control" name="category_id">
                                                <option value="">Выберите категория</option>
                                                <?php foreach ($categories as $i => $c) : ?>
                                                    <option <?=$category->id == $c->id ? 'selected' : ''?> value="<?= $c->id ?>"><?= $c->title ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="search__btn btn btn-primary">Поиск</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="product-grid">
            <?php if (count($products) == 0) : ?>
                <h5 class="my-25 py-30"><?= t("Ничего не найдено") ?></h5>
            <?php endif ?>
            <div class="row mx-n10 mx-xxl-n15">
                <?php foreach ($products as $product) : ?>
                    <?= \frontend\widgets\Product::widget(['product' => $product]) ?>
                <?php endforeach ?>
            </div>
        </div>
        <?php if (count($products) > 0) : ?>
            <?= \frontend\widgets\MyPagination::widget(['pages' => $pages, 'count' => count($products)]) ?>
        <?php endif ?>
    </div>
</main>



<?php $this->registerJs('', \yii\web\View::POS_END); ?>