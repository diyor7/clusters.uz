<?php

use common\models\Cart;
use common\models\Company;
use common\models\Page;

$pages = Page::findAll(['type' => Page::TYPE_HEADER]);

$user_type = Yii::$app->session->get("user_type", "customer");

$cart_data = Cart::getUserCartData();

?>
<marquee behavior="alternate" direction="right" style="position: fixed; top: 0; left: 0; width: 100%; color: #fff; font-size: 16px; font-weight: bolder; line-height: 150%; text-shadow: #000000 0px 1px 1px; z-index: 225; background-color: red">
    <?=t("Сайт работает в тестовом режиме.")?>
</marquee>
<header class="front-page__header <?= isHomeUrl() ? 'pb-130' : '' ?>" style="margin-top: 24px">
    <div class="container-fluid <?= isHomeUrl() ? '' : 'py-15' ?>">
        <div class="row align-items-center <?= isHomeUrl() ? 'mb-60 mb-xxl-100' : '' ?>">
            <div class="col">
                <div class="logo position-relative">
                    <a class="stretched-link logo__link" href="<?= toRoute('/') ?>"></a>
                    <img src="/img/logo-alt.svg" width="48" alt="" class="logo__img">
                    <span class="logo__text"><?= t("Единый электронный<br>информационно-интерактивный<br>торговый портал") ?></span>
                </div>
            </div>
            <div class="col">
                <ul class="nav main__nav justify-content-end">
                    <?php foreach ($pages as $page) : ?>
                        <!-- <li class="nav-item"><a class="nav-link " href="<?= toRoute('/pages/' . $page->url) ?>"><?= $page->title ?></a></li> -->
                    <?php endforeach ?>
                    <li class="nav-item <?= isHomeUrl() ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= toRoute('/') ?>"><?= t("Главная") ?> <span class="sr-only">(current)</span></a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="<?= toRoute('/store/category') ?>"><?= t("Категории") ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= toRoute('/producers') ?>"><?= t("Производители") ?></a>
                    </li> -->
                    <li class="nav-item">
                        <?= \frontend\widgets\WLang::widget() ?>
                    </li>
                    <li class="profile-link nav-item dropdown  dropdown--profile">
                        <?php if (Yii::$app->user->isGuest) : ?>
                            <a class="nav-link d-flex align-items-center" href="<?= toRoute('/site/login') ?>"><?= t("Войти") ?> <i class="icon-log-in ml-5 fs-16"></i></a>
                        <?php else : ?>
                            <?php $company = Company::findOne(Yii::$app->user->identity->company_id); ?>
                            <a href="#!" class="nav-link d-inline-flex align-items-center dropdown-toggle" role="button" id="dropdownProfileLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= t("Личный кабинет") ?> <i class="icon-user ml-5 fs-16"></i>
                            </a>

                            <div class="dropdown-menu p-20 fs-15 fw-semi-bold" aria-labelledby="dropdownProfileLink">
                                <div class="dropdown-user d-flex w-100 align-items-center mb-5 pl-10">
                                    <div class="dropdown-user__name fs-15 text-white">ИНН: <?= $company->tin ?><br><?= $company->name ?></div>
                                </div>
                                <a class="dropdown-item" href="<?= toRoute('/user') ?>"><?= t("Кабинет заказчика") ?></a>
                                <a class="dropdown-item" href="<?= toRoute('/cabinet') ?>"><?= t("Кабинет поставщика") ?></a>
                                <a class="dropdown-item" data-method="post" href="<?= toRoute('/site/logout') ?>"><?= t("Выйти") ?></a>
                            </div>
                        <?php endif ?>
                    </li>
                </ul>
            </div>
        </div>
        <?php if (isHomeUrl()) : ?>
            <h1 class="display-4 text-center text-white mx-auto mb-60 mb-xxl-100 wow fadeInUp"><?= t("Единый электронный<br>информационно-интерактивный<br>торговый портал по отечественному<br>Кластеру медной промышленности") ?></h1>
            <!-- background-color: #F8F3E9; -->
            <div class="container-fluid py-40">
                <div class="front-page__search mb-50 wow fadeInUp">
                    <div class="row justify-content-center">
                        <div class="col-10 col-xxl-8">
                            <form class="d-flex w-100">
                                <input type="text" class="form-control" id="q" placeholder="Введите идентификационный номер или наименование продукта...">
                                <button type="submit" class="btn btn-secondary"><?= t("Найти товар") ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
</header>