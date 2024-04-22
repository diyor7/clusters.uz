<?php

use common\models\Product as ModelsProduct;
use frontend\widgets\Product;

$this->title = t("Избранные");

$this->params['breadcrumbs'][] = array(
    'label' => t("Личный кабинет"),
    'url' => toRoute('/cabinet')
);
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render("../layouts/_nav") ?>

<div class="new-bg-different py-30">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?= $this->render("../layouts/_menu") ?>
            </div>
            <div class="col-md-9">
                <ul class="nav nav-cabinet fs-15">
                    <li class="nav-item position-relative   pb-30 mr-15">
                        <a class="nav-link <?= $tab == "products" ? 'active' : '' ?> p-0" href="<?= toRoute('/user/favorite?tab=products') ?>"><?= t("Продукты") ?> (<?= count($products) ?>)</a>
                    </li>
                    <li class="nav-item position-relative  pb-30 mx-15">
                        <a class="nav-link p-0 <?= $tab == "users" ? 'active' : '' ?>" href="<?= toRoute('/user/favorite?tab=users') ?>"><?= t("Поставщики") ?> (<?= count($users) ?>)</a>
                    </li>
                </ul>

                <?php if ($tab == "products") : ?>
                    <?php if (count($products) == 0) : ?>
                        <h5><?= t("Ничего не найдено") ?></h5>
                    <?php endif ?>
                    <div class="products my-20">
                        <div class="product-grid">
                            <div class="row mx-n10 mx-xxl-n15">
                                <?php foreach ($products as $product) : ?>
                                    <?= Product::widget(['product' => $product, 'isFavorite' => true, 'className' => 'col-lg-4']) ?>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="i-list mb-30 mt-20">
                        <div class="i-list__head px-20 mb-20">
                            <div class="row no-gutters">
                                <div class="col">
                                    <div class="i-list__sortable"><?= t("Наименование") ?></div>
                                </div>
                                <div class="col-2 text-center">
                                    <div class="i-list__sortable"><?= t("Тип производителя") ?></div>
                                </div>
                                <div class="col-2 text-center">
                                    <div class="i-list__sortable"><?= t("Регион") ?></div>
                                </div>
                                <div class="col-2 text-right">
                                    <div class="i-list__sortable"><?= t("Кол-во продуктов") ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="i-list__body">
                            <div class="i-list__items">
                                <?php if (count($users) == 0) : ?>
                                    <div class="item shadow bg-white rounded mb-10 wow fadeInUp">
                                        <div class="item__head py-15 px-20 ">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col">
                                                    <h6 class="mb-0"><?= t("Ничего не найдено") ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                                <?php foreach ($users as $u) : ?>
                                    <div class="item shadow bg-white rounded mb-10 wow fadeInUp">
                                        <div class="item__head py-15 px-20 ">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col">
                                                    <div class="d-flex align-items-center">
                                                        <div class="item__favorite">
                                                            <a href="#" class="favorite-link favorite-link--active mr-15 align-middle  add-to-favorite" data-company_id="<?= $u->id ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?= \Yii::$app->user->isGuest ? t("Нужна авторизация") : "" ?>">
                                                                <i class="<?= $u->isFavorite ? 'icon-favorite' : 'icon-star' ?>"></i>
                                                            </a>
                                                        </div>
                                                        <div class="item__title">
                                                            <div class="d-flex align-items-center">
                                                                <a href="<?= toRoute(['/producers/' . $u->company->link]) ?>" class="item__name d-inline-block">
                                                                    <b><?= $u->company->name ?></b>
                                                                </a>
                                                                <i class="icon-external-link ml-10 text-muted fs-15"></i>
                                                            </div>
                                                            <div><small class="d-block"><?= $u->user_profile->activity_type ? $u->user_profile->activity_type : t("(не указано)") ?></small></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-2 text-center"><?= $u->company->typeName ?></div>
                                                <div class="col-2 text-center"><?= $u->company->region->title ?></div>
                                                <div class="col-2 text-right">
                                                    <div class="item__price"><?= ModelsProduct::find()->where(['company_id' => $u->company_id, 'status' => ModelsProduct::STATUS_ACTIVE])->count() ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid pt-40">

</div>
<?php $this->registerJs('', \yii\web\View::POS_END); ?>