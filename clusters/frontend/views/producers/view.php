<?php

use common\models\Product;

$this->title = $company->name;

$this->params['breadcrumbs'][] = array(
    'label' => t("Ремесленники"),
    'url' => toRoute('/crafter')
);

$this->params['breadcrumbs'][] = $this->title;
?>
<main>
    <div class="page-head pt-40 pb-30">
        <div class="container-fluid">
            <h1 class="page-title mb-xl-30"><?= $this->title ?></h1>
            <div class="row">
                <div class="col">
                    <div class="item mb-15">
                        <div class="item__title mb-5 font-weight-bold"><?= t("Деятельности") ?>:</div>
                        <div class="item__text"><?= $company->user->user_profile->activity_type ? $company->user->user_profile->activity_type : t("(не указано)") ?></div>
                    </div>
                    <div class="item mb-15">
                        <div class="item__title mb-5 font-weight-bold"><?= t("Телефон") ?>:</div>
                        <div class="item__text"><a class="text-dark" href="tel:<?= $company->user->username ?>"><?= $company->user->username ?></a></div>
                    </div>
                </div>
                <div class="col">
                    <div class="item mb-15">
                        <div class="item__title mb-5 font-weight-bold"><?= t("Почта") ?>:</div>
                        <div class="item__text"><a class="text-dark" href="mailto:<?= $company->email ?>"><?= $company->email ? $company->email : t("(не указано)") ?></a></div>
                    </div>
                    <div class="item mb-15">
                        <div class="item__title mb-5 font-weight-bold"><?= t("Вебсайт") ?>:</div>
                        <div class="item__text"><a class="text-dark" target="_blank" href="<?= $company->site ?>"><?= $company->site ? $company->site : t("(не указано)") ?></a></div>
                    </div>
                </div>
                <div class="col">
                    <div class="item mb-30">
                        <div class="item__title mb-5 font-weight-bold"><?= t("Кол-во продуктов") ?>:</div>
                        <div class="item__text"><?= Product::find()->where(['company_id' => $company->id, 'status' => Product::STATUS_ACTIVE])->count() ?></div>
                    </div>
                </div>
                <div class="col">
                    <div class="item mb-30">
                        <div class="item__title mb-5 font-weight-bold"><?= t("Адрес") ?>:</div>
                        <div class="item__text"><?= $company->address ? $company->address : t("(не указано)") ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <h4 class="title mb-35 wow fadeInUp mt-4 pt-4">Продукция организации</h4>
        <div class="product-grid">
            <?php if (count($products) == 0) : ?>
                <h6 class="mb-30"><?=t("Ничего не найдено")?></h6>
            <?php endif ?>
            <div class="row mx-n10 mx-xxl-n15">
                <?php foreach ($products as $product) : ?>
                    <?= \frontend\widgets\Product::widget(['product' => $product]) ?>
                <?php endforeach ?>
            </div>
        </div>
        <?php if (count($products) > 0) : ?>
            <?= \frontend\widgets\MyPagination::widget(['pages' => $pages, 'count' => count($products)]) ?>
        <?php endif ?>
    </div>
</main>
<?php $this->registerJs('', \yii\web\View::POS_END); ?>