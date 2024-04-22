<?php

use common\models\Product;

$this->title = t("Мои товары");

$this->params['breadcrumbs'][] = array(
    'label' => t("Личный кабинет"),
    'url' => toRoute('/user')
);

$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render("../layouts/_nav", [
    'btn_title' => t("Добавить товар"),
    'btn_url' => toRoute('/user/product/add')
]) ?>

<div class="new-bg-different py-30">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?= $this->render("../layouts/_menu") ?>
            </div>
            <div class="col-md-9">
                <ul class="nav nav-cabinet fs-15">
                    <li class="nav-item position-relative pb-30 mr-15">
                        <a class="nav-link p-0  <?= $tab == Product::STATUS_ACTIVE ? 'active' : '' ?>" href="<?= toRoute('/user/product') ?>">
                            <?= t("Активные продукты") ?> (<?= isset($counts[Product::STATUS_ACTIVE]) ? $counts[Product::STATUS_ACTIVE] + 0 : 0 ?>)
                        </a>
                    </li>
                    <li class="nav-item position-relative  pb-30 mx-15">
                        <a class="nav-link p-0 <?= $tab == Product::STATUS_INACTIVE ? 'active' : '' ?>" href="<?= toRoute('/user/product/archive') ?>">
                            <?= t("Продукты в архиве") ?> (<?= isset($counts[Product::STATUS_INACTIVE]) ? $counts[Product::STATUS_INACTIVE] + 0 : 0 ?>)
                        </a>
                    </li>
                    <li class="nav-item position-relative  pb-30 mx-15">
                        <a class="nav-link p-0 <?= $tab == Product::STATUS_MODERATING || $tab == Product::STATUS_MODERATING_AGAIN ? 'active' : '' ?>" href="<?= toRoute('/user/product/moderating') ?>">
                            <?= t("На модерации") ?> (<?= (isset($counts[Product::STATUS_MODERATING]) ? $counts[Product::STATUS_MODERATING] : 0) + (isset($counts[Product::STATUS_MODERATING_AGAIN]) ? $counts[Product::STATUS_MODERATING_AGAIN] + 0 : 0) ?>)
                        </a>
                    </li>
                    <li class="nav-item position-relative  pb-30 mx-15">
                        <a class="nav-link p-0 <?= $tab == Product::STATUS_NOT_MODERATED ? 'active' : '' ?>" href="<?= toRoute('/user/product/not-moderated') ?>">
                            <?= t("Не прошел модерацию") ?> (<?= isset($counts[Product::STATUS_NOT_MODERATED]) ? Product::STATUS_NOT_MODERATED + 0 : 0 ?>)
                        </a>
                    </li>
                    <li class="nav-item position-relative pb-30 mx-15">
                        <a class="nav-link p-0" href="<?= toRoute('/user/product/tn') ?>">
                            <?= t("ТН ВЭД") ?> (<?= \common\models\CompanyTn::find()->where(['company_id' => \Yii::$app->user->identity->company_id])->count() ?>)
                        </a>
                    </li>
                </ul>

                <div class="i-list mb-30 mt-10">
                    <div class="i-list__head mb-20">
                        <div class="row no-gutters">
                            <div class="col-3">
                                <div class="i-list__sortable"><?= t("Номер и наименование продукта") ?></div>
                            </div>
                            <div class="col-2 text-center">
                                <div class="i-list__sortable"><?= t("Количество") ?></div>
                            </div>
                            <div class="col-2 text-center">
                                <div class="i-list__sortable"><?= t("Статус") ?></div>
                            </div>
                            <?php if ($tab == Product::STATUS_NOT_MODERATED) : ?>
                                <div class="col text-center">
                                    <div class="i-list__sortable"><?= t("Причина") ?></div>
                                </div>
                            <?php endif ?>

                            <div class="col-2 text-center">
                                <div class="i-list__sortable"><?= t("Цена") ?></div>
                            </div>
                            <div class="col-auto" style="width: 35px;"></div>
                        </div>
                    </div>
                    <div class="i-list__body">
                        <div class="i-list__items">
                            <?php if (count($products) == 0) : ?>
                                <div class="item mb-10 wow fadeInUp">
                                    <div class="item__head py-15 px-20 ">
                                        <div class="text-center"><?= t("Ничего не найдено") ?></div>
                                    </div>
                                </div>
                            <?php endif ?>
                            <?php foreach ($products as $product) : ?>
                                <div class="item shadow bg-white rounded mb-10 wow fadeInUp">
                                    <div class="item__head py-15 px-20 ">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-3">
                                                <?php if ($product->image) : ?>
                                                    <img height="65px" src="<?= $product->path ?>" alt="<?= $product->title ?>" class="mh-120 mr-4">
                                                <?php endif ?>
                                                <a href="<?= toRoute('/user/product/update/' . $product->id) ?>" class="item__name"><b>№ <?= $product->id ?></b> / <span><?= $product->title ?></span></a>
                                            </div>
                                            <div class="col-2 text-center">
                                                <?= $product->quantity ?>
                                            </div>
                                            <div class="col-2 text-center">
                                                <span class="item__badge <?= $product->statusClass ?> d-inline-block"><?= $product->statusName ?></span>
                                            </div>
                                            <?php if ($tab == Product::STATUS_NOT_MODERATED) : ?>
                                                <div class="col text-center">
                                                    <?= $product->reason ?>
                                                </div>
                                            <?php endif ?>
                                            <div class="col-2 text-center"><?= showPrice($product->price) ?> <?= t("сум") ?></div>
                                            <div class="col pl-15">
                                                <a class="btn btn-primary fs-12 mb-3" href="<?= toRoute('/store/product/' . $product->url) ?>">
                                                    <?= t('Посмотреть') ?>
                                                </a>
                                                <a class="btn btn-outline-secondary fs-12 mb-3" href="<?= toRoute('/user/product/update/' . $product->id) ?>">
                                                    <i class="icon-edit mr-2"></i><?= t('Редактировать') ?>
                                                </a>
                                                <a class="btn btn-outline-danger fs-12 mb-3" href="<?= toRoute('/user/product/delete/' . $product->id) ?>" data-method="POST" data-confirm="<?= t('Вы уверены?') ?>">
                                                    <i class="icon-trash mr-2"></i><?= t('Удалить') ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>

                        <?= \frontend\widgets\MyPagination::widget(['pages' => $pages, 'count' => count($products)]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->registerJs('', \yii\web\View::POS_END); ?>