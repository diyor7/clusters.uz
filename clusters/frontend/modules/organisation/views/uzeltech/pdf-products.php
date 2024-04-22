<?php
use yii\helpers\Url;

$this->title = 'Каталог выпускаемой продукции'
?>

<style>
    .uzeltech .company {
        height: 410px;
    }
    .uzeltech .company .company__logo {
        height: 300px !important;
        width: 100% !important;
    }
</style>

<div class="new-bg-different">
    <div class="container py-30">
        <div class="d-flex align-items-start mb-15">
            <div class="mr-20">
                <img src="<?=$company->logo?>" alt="">
            </div>
            <div>
                <h1 class="new-title-4 mb-0 pt-2">
                    <?=$company->full_name?>
                    <?php // $type==1?Yii::t('frontend', 'Выпускаемая продукция'):Yii::t('frontend', 'Закупки')?>
                </h1>
            </div>
        </div>

        <div class="new-breadcrumbs d-flex align-items-center">
            <a href="<?= toRoute('/') ?>"><?=t("Главная")?></a>
            <span></span>
            <a href="<?=Url::to(['/organisation/uzeltech/products-all'])?>"><?=$company->full_name?></a>
            <span></span>
            <?php if ($type==0):?>
                <a href="<?=Url::to(['/organisation/uzeltech/index', 'id' => $company->id, 'type' => 0])?>"><?php echo Yii::t('frontend', "Импорт");?></a>
            <?php elseif($type==2):?>
                <a href="<?=Url::to(['/organisation/uzeltech/index', 'id' => $company->id, 'type' => 2])?>"><?php echo Yii::t('frontend', "Местные закупки");?></a>
            <?php elseif($type==1):?>
                <a href="<?=Url::to(['/organisation/uzeltech/products-all', 'id' => $company->id, 'type' => 1])?>"><?php echo Yii::t('frontend', "Выпускаймая продукция");?></a>
            <?php else:?>
                <a href="#"><?=$this->title?></a>
            <?php endif;?>
        </div>
    </div>
</div>

<div class="container organ uzeltech z-index-1 bg-white position-relative mb-35 py-35 mt-50 overflow-hidden">
    <section class="pt-0 mb-60 pb-0 tour-360 fs-18 company__about mb-100">
        <ul class="nav mb-45 category__types">
            <li class="nav-item <?=$type==0?'active':''?>">
                <a href="<?=Url::to(['/organisation/uzeltech/index', 'id' => $company->id, 'type' => 0])?>" class="nav-link px-0 mr-15 fs-24 fw-semi-bold"><?php echo Yii::t('frontend', "Импорт");?></a>
            </li>
            <li class="nav-item <?=$type==2?'active':''?>">
                <a href="<?=Url::to(['/organisation/uzeltech/index', 'id' => $company->id, 'type' => 2])?>" class="nav-link px-0 mr-15 fw-semi-bold fs-24"><?php echo Yii::t('frontend', "Местные закупки");?></a>
            </li>
            <li class="nav-item <?=$type==1?'active':''?>">
                <a href="<?=Url::to(['/organisation/uzeltech/products-all', 'id' => $company->id, 'type' => 1])?>" class="nav-link px-0 fs-24 fw-semi-bold"><?php echo Yii::t('frontend', "Выпускаймая продукция");?></a>
            </li>
        </ul>

        <h1 class="page-title font-weight-bold fs-36 pb-25" id="page-name"><?=Yii::t('frontend', 'Выпускаемая продукция')?></h1>
        <p class="pb-20"><?=Yii::t('frontend', 'Ассоциация «Узэлтехсаноат» объединяет производителей кабельно-проводниковой продукции, электробытовой техники и электросилового оборудования.')?></p>
        <div class="row mx-0 companies pdf_sections">
            <div class="col-4 mb-20">
                <a href="<?=\yii\helpers\Url::to(['/organisation/uzeltech/product-single', 'section' => 1])?>" class="d-block">
                    <div class="company shadow-none border-0 py-20 px-20 mx-auto mw-100">
                        <div style="background-image: url('/organisations/<?=$company->folder?>/src/img/kabel.jpg')" class="company__logo mb-20"></div>
                        <div class="company__text text-center font-weight-bold"><?=Yii::t('frontend', 'ПРОИЗВОДСТВО КАБЕЛЬНО-ПРОВОДНИКОВОЙ ПРОДУКЦИИ')?></div>
                    </div>
                </a>
            </div>
            <div class="col-4 mb-20">
                <a href="<?=\yii\helpers\Url::to(['/organisation/uzeltech/product-single', 'section' => 2])?>" class="d-block">
                    <div class="company shadow-none border-0 py-20 px-20 mx-auto mw-100">
                        <div style="background-image: url('/organisations/<?=$company->folder?>/src/img/bytovy.jpg')" class="company__logo mb-20"></div>
                        <div class="company__text text-center font-weight-bold"><?=Yii::t('frontend', 'ПРОИЗВОДСТВО ЭЛЕКТРОБЫТОВОЙ ПРОДУКЦИИ')?></div>
                    </div>
                </a>
            </div>
            <div class="col-4 mb-20">
                <a href="<?=\yii\helpers\Url::to(['/organisation/uzeltech/product-single', 'section' => 3])?>" class="d-block">
                    <div class="company shadow-none border-0 py-20 px-20 mx-auto mw-100">
                        <div style="background-image: url('/organisations/<?=$company->folder?>/src/img/elsila.jpg')" class="company__logo mb-20"></div>
                        <div class="company__text text-center font-weight-bold"><?=Yii::t('frontend', 'ПРОИЗВОДСТВО ЭЛЕКТРОСИЛОВОГО ОБОРУДОВАНИЯ')?></div>
                    </div>
                </a>
            </div>
        </div>
    </section>
</div>
