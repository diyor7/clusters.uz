<?php
$this->title = 'Каталог выпускаемой продукции'

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
            <a href="<?=\yii\helpers\Url::to(['/organisation/uzeltech/products-all'])?>"><?= $this->title ?></a>
            <span></span>
            <p>
                <?php
                if($section == 1){
                    echo Yii::t('frontend', 'Каталог кабельной продукции');
                }elseif ($section == 2) {
                    echo Yii::t('frontend', 'Каталог электробытовой техники');
                }else {
                    echo Yii::t('frontend', 'Каталог электросиловых устройств');
                }
                ?>
            </p>
        </div>
    </div>
</div>

<div class="container z-index-1 bg-white position-relative px-40 mb-35 py-35 mt-50 overflow-hidden">
    <section class="pt-0 mb-60 pb-0 tour-360 fs-18 company__about mb-100">
        <h1 class="page-title font-weight-bold fs-36 pb-25" id="page-name">

            <?php
            if($section == 1){
                echo Yii::t('frontend', 'Каталог кабельной продукции');
            }elseif ($section == 2) {
                echo Yii::t('frontend', 'Каталог электробытовой техники');
            }else {
                echo Yii::t('frontend', 'Каталог электросиловых устройств');
            }
            ?>

        </h1>

        <?php if (!empty($product)):?>
        <div id="pdf1" class="pdf-product" style="height: 900px"></div>
            <?php $pdf = $product->link?>
            <?php $script = <<< JS
PDFObject.embed("/organisations/$company->folder/uploads/files/{$pdf}", "#pdf1");
JS;
            $this->registerJs($script, \yii\web\View::POS_READY);
            ?>
        <?php endif;?>
    </section>
</div>
