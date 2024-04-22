<?php
$this->title = $page->title;

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
        <?= $page->description ?>
    </div>
</div>

<?php $this->registerJs('', \yii\web\View::POS_END); ?>