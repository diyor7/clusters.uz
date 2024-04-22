<?php
$this->title = t('Конференция');

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="bg-white">
    <div class="container py-30">
        <div class="d-flex align-items-around mb-25" style="justify-content: space-between;">
            <div>
                <h1 class="new-title-4 mb-0 pt-2">
                    <?= $this->title ?>
                </h1>
            </div>
            <div class="">
                <a class="btn btn-success text-white" href="<?=toRoute(['/page/forum'])?>"><?=t("Участие в конференции")?></a>
            </div>
        </div>

        <div class="new-breadcrumbs d-flex">
            <a href="<?= toRoute('/') ?>"><?= t("Главная") ?></a>
            <span></span>
            <p><?= $this->title ?></p>
        </div>


    </div>
</div>

<div class="new-bg-different">
    <div class="container py-40">
        <?= $model->description ?>
    </div>
</div>

<?php $this->registerJs('', \yii\web\View::POS_END); ?>