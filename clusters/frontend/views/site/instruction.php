<?php
$this->title = t("Инструкция");

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
            <a href="<?= toRoute('/') ?>"><?= $this->title ?></a>
            <span></span>
            <p><?= $this->title ?></p>
        </div>
    </div>
</div>

<div class="new-bg-different">
    <div class="container py-40">
        <div class="row instruction-v2">
            
            <?php foreach($models as $md): ?>
            <div class="col-lg-12">
                <a href="<?=$md->fileurl?>" class="stretched-link row border-bottom align-items-center link--black mx-0 mt-20 pb-15" target="_blank">
                    <div class="col-auto pl-5"><img src="<?=$md->iconurl?>" alt=""></div>
                    <div class="col pl-0">
                        <p class="fs-16 p-0 m-0 font-weight-bold"><?=$md->title?></p>
                        <!-- <span class="text-black-50 fs-14">Размер файла: <?= '' //filesize($md->fileurl)?> МБ</span> -->
                    </div>
                    <div class="col-auto text-center text-black-50">
                        <i class="icon-download fs-20 mr-2"></i> <?=t("Скачать")?>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
            
        </div>
    </div>
</div>

<?php $this->registerJs('', \yii\web\View::POS_END); ?>