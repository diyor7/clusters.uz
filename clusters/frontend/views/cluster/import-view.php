<?php

use frontend\widgets\MyPagination;
use chillerlan\QRCode\QRCode;

$this->title = $plan->title;
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
            <a href="<?= toRoute('/cluster/' . $data['cluster'] . '/import') ?>"><?= t("Импорт") ?></a>
            <span></span>
            <p><?= $this->title ?></p>
        </div>
    </div>
</div>

<div class="new-bg-different">
    <div class="container py-40">
        <div class="mb-30">
            <div class="d-doc bg-white shadow rounded h-100">
                <div class="d-doc__body p-30">
                    <div class="row">
                        <div class="col-12 col-xxl-12">
                            <div class="row mb-10 align-items-center">
                                <div class="col-12">
                                    <div class="d-doc__total">
                                        <a class="" href="#!" onclick="window.print()">
                                            <i class="icon-printer"></i>
                                        </a>
                                        <div class="row">
                                            <div class="col">
                                                <div class="d-doc__title"><?= t("Название товара") ?>:</div>
                                                <div class="d-doc__text d-doc-text--price fs-24 font-weight-bold"><?= $plan->title ?></div>
                                            </div>
                                            <div class="col">
                                                <div class="d-doc__title"><?= t("Дата") ?>:</div>
                                                <div class="d-doc__text d-doc-text--price fs-24 font-weight-bold">
                                                    <?= $plan->year ?>
                                                    <?= $plan->activeKvartal() ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-doc__brand">
                                <div class="brand__details mt-10 fs-15">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div id="" class="product-info__gallery  position-relative">
                                                <?php if ($plan->filename && (endsWith($plan->filename, "png") || endsWith($plan->filename, "jpg") || endsWith($plan->filename, "jpeg"))) : ?>
                                                    <div class="item rounded-lg" style="background-image: url('<?= siteUrl() . 'uploads/plan/' . $plan->filename ?>')">
                                                        <a href="<?= siteUrl() . 'uploads/plan/' . $plan->filename ?>" class="stretched-link gallery-popup-link">
                                                            <i class="icon-maximize" title="Увеличить фото"></i>
                                                        </a>
                                                    </div>
                                                <?php elseif ($plan->filename) : ?>
                                                    <a href="<?= siteUrl() . 'uploads/plan/' . $plan->filename ?>" class="d-inline-block mb-10" target="_blank"><?= t("Файл") ?></a>
                                                <?php endif ?>
                                            </div>
                                            <div class="product-new-description mt-20">
                                                <h4><?= t("Функциональность") ?></h4>
                                                <div class="content">
                                                    <?= $plan->functionality ?>
                                                </div>
                                                <h4><?= t("Технические характеристики") ?></h4>
                                                <div class="content">
                                                    <?= $plan->technicality ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="brand__detail2 mb-10 ">
                                                <div class="d-doc__title fw-semi-bold mb-5"><?= t("Категория") ?>:</div>
                                                <div class="d-doc__text"><?= $plan->category ? $plan->category->title : "" ?></div>
                                            </div>
                                            <div class="brand__detail2 mb-10 ">
                                                <div class="d-doc__title fw-semi-bold mb-5"><?= t("Объем") ?>:</div>
                                                <div class="d-doc__text"><?= $plan->unit_val . ' ' . $plan->unit->title ?></div>
                                            </div>
                                            <div class="brand__detail2 mb-10 ">
                                                <div class="d-doc__title fw-semi-bold mb-5"><?= t("Ссылка") ?>:</div>
                                                <div class="d-doc__text">
                                                    <?php
                                                    $d = 'http://clusters.uz' . toRoute('/cluster/' . $data['cluster'] . '/import/' . $plan->id);
                                                    echo '<img style="width: 200px" src="' . (new QRCode())->render($d) . '" alt="QR Code" />';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>