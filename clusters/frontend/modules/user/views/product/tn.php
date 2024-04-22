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
    'btn_title' => t("Добавить ТН ВЭД"),
    'btn_url' => toRoute('/user/product/add-tn'),
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
                        <a class="nav-link p-0" href="<?= toRoute('/user/product') ?>">
                            <?= t("Активные продукты") ?> (<?= isset($counts[Product::STATUS_ACTIVE]) ? $counts[Product::STATUS_ACTIVE] + 0 : 0 ?>)
                        </a>
                    </li>
                    <li class="nav-item position-relative pb-30 mx-15">
                        <a class="nav-link p-0" href="<?= toRoute('/user/product/archive') ?>">
                            <?= t("Продукты в архиве") ?> (<?= isset($counts[Product::STATUS_INACTIVE]) ? $counts[Product::STATUS_INACTIVE] + 0 : 0 ?>)
                        </a>
                    </li>
                    <li class="nav-item position-relative pb-30 mx-15">
                        <a class="nav-link p-0" href="<?= toRoute('/user/product/moderating') ?>">
                            <?= t("На модерации") ?> (<?= (isset($counts[Product::STATUS_MODERATING]) ? $counts[Product::STATUS_MODERATING] : 0) + (isset($counts[Product::STATUS_MODERATING_AGAIN]) ? $counts[Product::STATUS_MODERATING_AGAIN] + 0 : 0) ?>)
                        </a>
                    </li>
                    <li class="nav-item position-relative pb-30 mx-15">
                        <a class="nav-link p-0" href="<?= toRoute('/user/product/not-moderated') ?>">
                            <?= t("Не прошел модерацию") ?> (<?= isset($counts[Product::STATUS_NOT_MODERATED]) ? Product::STATUS_NOT_MODERATED + 0 : 0 ?>)
                        </a>
                    </li>
                    <li class="nav-item position-relative  pb-30 mx-15">
                        <a class="nav-link p-0 active" href="<?= toRoute('/user/product/tn') ?>">
                            <?= t("ТН ВЭД") ?> (<?= \common\models\CompanyTn::find()->where(['company_id' => \Yii::$app->user->identity->company_id])->count() ?>)
                        </a>
                    </li>
                </ul>

                <div class="i-list mb-30 mt-10">
                    <div class="i-list__head px-20 mb-20">
                        <div class="row no-gutters">
                            <div class="col-3">
                                <div class="i-list__sortable"><?= t("ТН ВЭД") ?></div>
                            </div>
                            <div class="col-3 text-center">
                                <div class="i-list__sortable"><?= t("Наименование") ?></div>
                            </div>
                            <div class="col-3 text-center">
                                <div class="i-list__sortable"><?= t("Сертификат") ?></div>
                            </div>
                            <div class="col text-center">
                                <div class="i-list__sortable"><?= t("Доп. инфо") ?></div>
                            </div>
                            <div class="col-auto" style="width: 35px;"></div>
                        </div>
                    </div>
                    <div class="i-list__body">
                        <div class="i-list__items">
                            <?php if (count($tns) == 0) : ?>
                                <div class="item shadow bg-white rounded mb-10 wow fadeInUp">
                                    <div class="item__head py-15 px-20 ">
                                        <div class="text-center"><?= t("Ничего не найдено") ?></div>
                                    </div>
                                </div>
                            <?php endif ?>
                            <?php foreach ($tns as $tn) : ?>
                                <div class="item shadow bg-white rounded mb-10 wow fadeInUp">
                                    <div class="item__head py-15 px-20 ">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-3">
                                                <b><?= $tn->tn->code ?></b>
                                            </div>
                                            <div class="col-3 text-center">
                                                <?= $tn->tn->title ?>
                                            </div>
                                            <div class="col-3 text-center">
                                                <?php if ($tn->tn->cert_required == 1) : ?>
                                                    <span class="item__badge item__badge--status-3 d-inline-block"><?= $tn->certificate ?></span>
                                                <?php else : ?>
                                                    <span class="item__badge item__badge--status-1 d-inline-block"><?= t("Не требуется") ?></span>
                                                <?php endif ?>
                                            </div>
                                            <div class="col text-center">
                                                <?= $tn->message ?>
                                            </div>
                                            <div class="col pl-15">
                                                <a class="btn btn-outline-secondary mb-3 px-10 py-1 fs-13" href="<?= toRoute('/user/product/update-tn/' . $product->id) ?>">
                                                    <i class="icon-edit mr-2"></i><?= t('Редактировать') ?>
                                                </a>
                                                <a class="btn btn-outline-danger mb-3 px-10 py-1 fs-13" href="<?= toRoute('/user/product/delete-tn/' . $product->id) ?>" data-method="POST" data-confirm="<?= t('Вы уверены?') ?>">
                                                    <i class="icon-trash mr-2"></i><?= t('Удалить') ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->registerJs('', \yii\web\View::POS_END); ?>