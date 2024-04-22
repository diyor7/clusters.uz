<?php
$this->title = t("Новости");

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
        <div class="row">
            <?php foreach ($models as $model) : ?>
                <div class="col-md-3 mb-35">
                    <div class="new-product">
                        <div>
                            <a href="<?= toRoute(['/page/new/' . strtolower(rus2translit($model->title)) . '--' . $model->id]) ?>">
                                <div class="image">
                                    <img src="<?= $model->imageurl ? $model->imageurl : '/img/noimage.jpg' ?>" alt="<?= $model->title ?>" class="w-100">
                                </div>
                            </a>
                            <div class="info">
                                <div class="count d-flex justify-content-between">
                                    <div>
                                        <?= date("d.m.Y", strtotime($model->created_at)) ?>
                                    </div>
                                </div>
                                <a href="<?= toRoute(['/page/new/' . strtolower(rus2translit($model->title)) . '--' . $model->id]) ?>">
                                    <div class="price mb-25">
                                        <?= $model->title ?>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="name px-25 pb-25 mb-0">
                            <a href="<?= toRoute(['/page/new/' . strtolower(rus2translit($model->title)) . '--' . $model->id]) ?>"><?= t("Подробнее") ?></a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

    </div>
</div>