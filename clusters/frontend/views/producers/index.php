<?php

use common\models\Company;
use common\models\Product;

$this->title = t("Производители");

$this->params['breadcrumbs'][] = $this->title;
?>
<main>
    <div class="page-head pt-40 pb-30">
        <div class="container-fluid">
            <h1 class="page-title mb-0"><?= $this->title ?></h1>
        </div>
    </div>
    <div class="filter mb-30 shadow position-relative">
        <div class="bg-gray py-20">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="d-flex align-items-center">
                            <div class="filter__icon" data-toggle="tooltip" data-placement="top" title="Фильтр">
                                <a data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
                                    <i class="icon-sliders mr-5"></i>
                                    <small class="align-bottom"><?= t("Фильтр") ?></small>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">

                    </div>
                </div>
            </div>
        </div>
        <div class="filter__dropdown collapse <?= !!$name || !!$region_id || !!$type ? 'show' : '' ?>" id="collapseFilter">
            <form action="<?= toRoute('/producers') ?>" method="GET">
                <div class="filter__content bg-white py-30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name"><?= t("Наименование") ?>:</label>
                                    <input type="text" class="form-control" name="name" placeholder="<?= t("Введите наименование...") ?>" value="<?= $name ?>">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label><?= t("Тип производителя") ?>:</label>
                                    <select class="form-control" name="type">
                                        <option value=""><?= t(" - Выбрать - ") ?></option>
                                        <?php foreach (Company::getTypes() as $t => $label) : ?>
                                            <option <?= $type == $t ? 'selected' : '' ?> value="<?= $t ?>"><?= $label ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label><?= t("Регион") ?>:</label>
                                    <select class="form-control" name="region_id">
                                        <option value=""><?= t(" - Выбрать - ") ?></option>
                                        <?php foreach (\common\models\Region::find()->all() as $region) : ?>
                                            <option <?= $region_id == $region->id ? 'selected' : '' ?> value="<?= $region->id ?>"><?= $region->title ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter__footer bg-gray py-20">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col">

                            </div>
                            <div class="col text-right">
                                <div class="filter__btns">
                                    <a class="btn btn-link d-inline-flex align-items-center" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter"><?= t("Скрыть фильтр") ?> <i class="icon-chevron-up font-weight-bold fs-16 ml-5"></i></a>
                                    <button class="btn btn-outline-primary rounded-pill px-25"><?= t("Фильтровать") ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <div class="container-fluid">
        <div class="i-list mb-30 mt-n10">
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
                    <div class="col-2 text-center">
                        <div class="i-list__sortable"><?= t("Адрес") ?></div>
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
                    <?php foreach ($users as $user) : ?>
                        <div class="item shadow bg-white rounded mb-10 wow fadeInUp">
                            <div class="item__head py-15 px-20 ">
                                <div class="row no-gutters align-items-center">
                                    <div class="col">
                                        <div class="d-flex align-items-center">
                                            <div class="item__favorite">
                                                <a href="#" class="favorite-link favorite-link--active mr-15 align-middle  add-to-favorite" data-company_id="<?= $user->id ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?= \Yii::$app->user->isGuest ? t("Нужна авторизация") : ""?>">
                                                    <i class="<?= $user->isFavorite ? 'icon-favorite' : 'icon-star' ?>"></i>
                                                </a>
                                            </div>
                                            <div class="item__title">
                                                <div>
                                                    <a href="<?= toRoute(['/producers/' . $user->company->link]) ?>" class="item__name d-inline-block">
                                                        <b><?= $user->company->name ?></b>
                                                    </a>
                                                    <i class="icon-external-link ml-10 text-muted fs-15"></i>
                                                </div>
                                                <div><small class="d-block"><?= $user->user_profile->activity_type ? $user->user_profile->activity_type : t("(не указано)") ?></small></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2 text-center"><?= $user->company->typeName ?></div>
                                    <div class="col-2 text-center"><?= $user->company->region->title ?></div>
                                    <div class="col-2 text-center"><?= $user->company->address ?></div>
                                    <div class="col-2 text-right">
                                        <div class="item__price"><?= Product::find()->where(['company_id' => $user->company_id, 'status' => Product::STATUS_ACTIVE])->count() ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php $this->registerJs('', \yii\web\View::POS_END); ?>