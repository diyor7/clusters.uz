<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\models\organisation\umk\Product;
//use frontend\widgets\FeedbackForm;
/* @var $company \common\models\Company */
/* @var $category \common\models\Category */
/* @var $products \common\models\Product */
/* @var $product \common\models\Product */
/* @var $pagination  */

$currency = ($product->currency == 0)?($type == 0)?Product::getNameCurrency(1):Product::getNameCurrency(4):$product->getNameCurrency($product->currency);
$this->title = $product->name;
?>
<style>
    .category__product dt {
        float: left;
        width: 55%;
        overflow: hidden;
        white-space: nowrap;
    }
    .category__product dt:after {
        content: " .................................................................................. ";
    }
    .category__product dd {
        float: left;
        width: 45%;
        overflow: hidden;
        padding-left: 5px;
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
            <a href="#"><?=$company->full_name?></a>
            <span></span>
            <a href="<?=Url::to(['/organisation/umk/index', 'id' => $company->id, 'type' => $type])?>">Каталог выпускаемой продукции</a>
            <span></span>
            <p><?= $this->title ?></p>
        </div>
    </div>
</div>

<div class="container z-index-1 bg-white position-relative px-40 mb-35 py-35 mt-50 overflow-hidden">

    <section class="pt-0 mb-60 pb-0 category">
        <h1 class="page-title font-weight-bold fs-36 pb-25" id="page-name"><?=$product->name?></h1>

        <div class="category__product row pt-35">
            <div class="col-9">
                <div class="row">
                    <div class="col-5">
                            <div id="gallery" class="product-info__gallery owl-carousel d-block owl-theme shadow-lg position-relative">
                                <?php if($type == 1):?>
                                        <div class="item rounded-lg" style="background-image: url('/uploads/product/<?=$product->id?>.jpg')">
                                            <a href="/uploads/product/<?=$product->id?>.jpg" class="stretched-link gallery-popup-link"><i class="icon-maximize" title="Увеличить фото"></i></a>
                                        </div>
                                <?php endif;?>
                                <?php if($type == 0):?>
                                    <?php if(!empty($product->images)){ foreach ($product->images as $image):?>
                                        <div class="item rounded-lg" style="background-image: url('<?=$company->link?><?='/uploads/images/products/'.$image->value?>')">
                                            <a href="<?=$company->link?><?='/uploads/images/products/'.$image->value?>" class="stretched-link gallery-popup-link"><i class="icon-maximize" title="Увеличить фото"></i></a>
                                        </div>
                                    <?php endforeach;}else{?>
                                        <div class="item rounded-lg" style="background-image: url('/img/noimage.jpg')">
                                            <a href="/img/noimage.jpg" class="stretched-link gallery-popup-link"><i class="icon-maximize" title="Увеличить фото"></i></a>
                                        </div>
                                    <?php }?>
                                <?php endif;?>
                            </div>
                    </div>
                    <div class="col-7">

                        <dl class="mt-30 pb-30">
                            <dt><?php echo Yii::t('frontend', "ТН ВЭД");?>:</dt>
                            <dd> <?=$product->code?></dd>

                            <dt><?php echo Yii::t('frontend', "Ед. изм.");?>:</dt>
                            <dd> <?=$product->units_measure_id?></dd>
                        </dl>
                        <h4 class="font-weight-bold mt-30 pt-30"><?php echo Yii::t('frontend', "Технические характеристики");?></h4>
                        <p><?=$product->description?></p>

                    </div>
                </div>
            </div>
        </div>

    </section>

</div>
