<?php

use frontend\widgets\MyPagination;
use frontend\widgets\Product;

$this->title =  t("Выпускаемая продукция");
?>

<div class="bg-white">
    <div class="container py-30">
        <div class="d-flex align-items-start">
            <div class="mr-20">
                <a href="<?= toRoute('/store/category') ?>">
                    <img src="/img/newplatform1.png" alt="">
                </a>
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

        <div class="all-products">
            <?= t("Все товары") ?>: <?= $count ?>
        </div>

        <div class="mb-30">
            <div class="row mx-10 mx-xxl-n15">
                <?php foreach ($products as $product) : ?>
                    <?= Product::widget(['product' => $product]) ?>
                <?php endforeach ?>
            </div>

            <?= MyPagination::widget(['pages' => $pages, 'count' => count($products)]) ?>
        </div>
    </div>
</div>