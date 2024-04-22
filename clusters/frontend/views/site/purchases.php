<?php
$this->title = t("Закупки по площадкам");

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bg-white">
    <div class="container py-30">
        <div class="d-flex align-items-start mb-25">
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

<div class="new-bg-different">
    <div class="container py-40">
        <div class="row my-60 align-items-stretch align-content-stretch">

            <div class="col-lg-3">
                <a href="<?= toRoute('/store/category') ?>">
                    <div class="new-platform">
                        <div class="image">
                            <img src="/img/newplatform1.png" alt="">
                        </div>

                        <div class="name">
                            <?= t("Электронный магазин") ?>
                        </div>

                        <div class="desc">
                            <?= t("Государственная закупка однотипных товаров") ?>
                        </div>

                        <div class="contract">
                            <h4><?= t("Договора") ?></h4>
                            <div class="d-flex mt-15 justify-content-between">
                                <div>
                                    <p><?= t("Количество") ?></p>
                                    <h5><b>362</b> <small><?= t("шт.") ?></small></h5>
                                </div>
                                <div>
                                    <p><?= t("Сумма") ?></p>
                                    <h5><b>1 358</b> <small>млн. сум</small></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

            </div>

            <div class="col-lg-3">
                <a href="<?= toRoute('/auction') ?>">
                    <div class="new-platform">
                        <div class="image">
                            <img src="/img/newplatform2.png" alt="">
                        </div>

                        <div class="name">
                            <?= t("Электронный конкурс") ?>
                        </div>

                        <div class="desc">
                            <?= t("Критерии определения победителя имеют не только денежную, но количественную и качественную оценку государственной закупки товара (работы, услуги)") ?>
                        </div>

                        <div class="contract">
                            <h4><?= t("Договора") ?></h4>
                            <div class="d-flex mt-15 justify-content-between">
                                <div>
                                    <p><?= t("Количество") ?></p>
                                    <h5><b>362</b> <small><?= t("шт.") ?></small></h5>
                                </div>
                                <div>
                                    <p><?= t("Сумма") ?></p>
                                    <h5><b>1 358</b> <small>млн. сум</small></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3">
                <a href="<?= toRoute('/auction') ?>">
                    <div class="new-platform">
                        <div class="image">
                            <img src="/img/newplatform3.png" alt="">
                        </div>

                        <div class="name">
                            <?= t("Аукцион") ?>
                        </div>

                        <div class="desc">
                            <?= t("Аукцион на понижение стартовой цены - Государственная закупка товаров со стандартными свойствами") ?>
                        </div>

                        <div class="contract">
                            <h4><?= t("Договора") ?></h4>
                            <div class="d-flex mt-15 justify-content-between">
                                <div>
                                    <p><?= t("Количество") ?></p>
                                    <h5><b>362</b> <small><?= t("шт.") ?></small></h5>
                                </div>
                                <div>
                                    <p><?= t("Сумма") ?></p>
                                    <h5><b>1 358</b> <small>млн. сум</small></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3">
                <a href="<?= toRoute('/auction') ?>">
                    <div class="new-platform">
                        <div class="image">
                            <img src="/img/newplatform3.png" alt="">
                        </div>

                        <div class="name">
                            <?= t("Тендер") ?>
                        </div>

                        <div class="desc">
                            <?= t("Критерии определения победителя имеют не только денежную, но количественную и качественную оценку государственной закупки товара (работы, услуги)") ?>
                        </div>

                        <div class="contract">
                            <h4><?= t("Договора") ?></h4>
                            <div class="d-flex mt-15 justify-content-between">
                                <div>
                                    <p><?= t("Количество") ?></p>
                                    <h5><b>362</b> <small><?= t("шт.") ?></small></h5>
                                </div>
                                <div>
                                    <p><?= t("Сумма") ?></p>
                                    <h5><b>1 358</b> <small>млн. сум</small></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<div class=" new-bg-different">
    <div class="container py-40">
        <h3 class="new-title-2"><?= t("Выпускаемая <b>продукция</b>") ?></h3>

        <div class="row my-70">
            <?php foreach ($products as $product) : ?>
            <?= \frontend\widgets\Product::widget(['product' => $product]) ?>
            <?php endforeach ?>
        </div>
    </div>
</div>

<?php $this->registerJs('', \yii\web\View::POS_END); ?>