<?php
$this->title = $data['title'];
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
            <p><?= $this->title ?></p>
        </div>
    </div>
</div>

<div class="new-bg-different">
    <div class="container py-40 mh-40">
        <div class="categories__nav sticky-top mb-15 wow fadeInUp new-bg-different">
            <div id="categories" class="row">
                <div class="col-md-4 col-lg-4 mb-25">
                    <div class="item shadow position-relative rounded d-flex align-items-center h-100">
                        <div class="item__img shadow mr-15" style="background-image: url('/img/production.png'); background-size: contain"></div>
                        <div class="item__name"><a class="stretched-link" href="<?= toRoute("/cluster/" . $data['cluster'] . "/product") ?>"><?= t("Выпускаемая продукция") ?></a></div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4 mb-25">
                    <div class="item shadow position-relative rounded d-flex align-items-center h-100">
                        <div class="item__img shadow mr-15" style="background-image: url('/img/import2.png'); background-size: contain"></div>
                        <div class="item__name"><a class="stretched-link" href="<?= toRoute("/cluster/" . $data['cluster'] . "/import") ?>"><?= t("Импорт") ?></a></div>
                    </div>
                </div>
                <!-- <div class="col-md-4 col-lg-4 mb-25">
                    <div class="item shadow position-relative rounded d-flex align-items-center h-100">
                        <div class="item__img shadow mr-15" style="background-image: url('/img/import.png'); background-size: contain"></div>
                        <div class="item__name"><a class="stretched-link" href="<?= toRoute("/cluster/" . $data['cluster'] . "/trade") ?>"><?= t("Местные закупки") ?></a></div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>