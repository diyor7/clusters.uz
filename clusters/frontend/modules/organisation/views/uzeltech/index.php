<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $company \common\models\Company */
/* @var $child \common\models\Company */
/* @var $categories \common\models\Category */
/* @var $category \common\models\Category */
/* @var $type int */
$this->title = $company->getNameType($type)

?>

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
            <a href="#"><?=$company->full_name?></a>
            <span></span>
            <?php if ($type==0):?>
                <a href="<?=Url::to(['/organisation/agmk/index', 'id' => $company->id, 'type' => 0])?>"><?php echo Yii::t('frontend', "Импорт");?></a>
            <?php elseif($type==2):?>
                <a href="<?=Url::to(['/organisation/agmk/index', 'id' => $company->id, 'type' => 2])?>"><?php echo Yii::t('frontend', "Местные закупки");?></a>
            <?php elseif($type==1):?>
                <a href="<?=Url::to(['/organisation/agmk/index', 'id' => $company->id, 'type' => 1])?>"><?php echo Yii::t('frontend', "Выпускаймая продукция");?></a>
            <?php else:?>
                <a href="#"><?=$this->title?></a>
            <?php endif;?>
        </div>
    </div>
</div>

<div class="container organ z-index-1 bg-white position-relative mb-35 py-35 mt-50 overflow-hidden">
    <section class="pt-0 mb-60 pb-0 category">
<!--        <h1 class="page-title font-weight-bold fs-36 pb-25" id="page-name"></h1>-->
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
            <div>
                <?php if ($type==1):?>
                    <?=$company->full_name.Yii::t('frontend', ' предлагает для освоения отечественным производителям выпускаемой продукции.')?>
                <?php elseif($type==2):?>
                    <?=$company->full_name.Yii::t('frontend', ' предлагает местные закупки.')?>
                <?php elseif($type==3):?>
                    <?=$company->full_name.Yii::t('frontend', ' предлагает следующие услуги.')?>
                <?php else:?>
                    <?=$company->full_name.Yii::t('frontend', ' предлагает для освоения отечественным производителям импортируемой продукции.')?>
                <?php endif;?>
            </div>
        <div class="company-categories">

            <div class="catalog my-xxl-20">
                <h2 class="page-title font-weight-bold mb-25 mt-35">
                    <?php if ($type==1):?>
                        <?=Yii::t('frontend', 'Каталог выпускаемой продукции')?>
                    <?php elseif($type==2):?>
                        <?=Yii::t('frontend', 'Каталог местных закупок')?>
                    <?php elseif($type==3):?>
                        <?=Yii::t('frontend', 'Каталог услуг')?>
                    <?php else:?>
                        <?=Yii::t('frontend', 'Каталог импортируемой продукции.')?>
                    <?php endif;?>
                </h2>
                <div class="row mx-n10 mx-xxl-n15">

                    <?php $i = 0; foreach ($company->categories as $category):?>
                        <?php $p_count = $category->getProductsByCompanyByType($company->id, $type, empty($company->parent_id))->count(); if ($p_count == 0) continue?>
                        <div class="col-4 col-xxl-4 px-10 px-xxl-15 mb-20 mb-xxl-30">
                            <div class="item rounded-lg position-relative d-flex align-items-center p-20 wow fadeInUp">
                                <a href="#" class="favorite-link position-absolute" data-toggle="tooltip" data-placement="top" title="<?=Yii::t('frontend', 'Добавить в избранное')?>"><i class="icon-favorite"></i></a>
                                <div class="item__img rounded-circle shadow mr-20">
                                    <?php if(!empty($category->image)):?>
                                        <div class="item__img-holder" style="background-image: url('/organisations/<?=$company->folder?>/uploads/images/category/<?=!empty($category->imagecol)?$category->imagecol:$category->image?>')"></div>
                                    <?php elseif (empty($category->image)):?>
                                        <div class="item__img-holder" style="background-image: url('/img/noimage.jpg')"></div>
                                    <?php endif;?>
                                </div>
                                <div class="item__content">
                                    <div class="item__name">
                                        <a href="<?=Url::to(['/organisation/uzeltech/products', 'id' => $company->id, 'category_id' => $category->id, 'type' => $type])?>" class="item__link stretched-link"><?=$category->name?></a>
                                    </div>
                                    <div class="item__count"><?php echo Yii::t('frontend', "Кол-во товаров");?>: <?=$p_count?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>

        </div>
    </section>

</div>
