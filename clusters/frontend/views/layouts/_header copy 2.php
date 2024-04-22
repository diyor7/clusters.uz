<?php

use common\models\Cart;
use common\models\Company;
use common\models\Page;

$pages = Page::findAll(['type' => Page::TYPE_HEADER]);

$user_type = Yii::$app->session->get("user_type", "customer");

$cart_data = Cart::getUserCartData();

?>
<marquee behavior="alternate" direction="right" style="position: fixed; top: 0; left: 0; width: 100%; color: #fff; font-size: 16px; font-weight: bolder; line-height: 150%; text-shadow: #000000 0px 1px 1px; z-index: 3333; background-color: red">
    <?=t("Сайт работает в тестовом режиме.")?>
</marquee>
<header class="home position-relative bg-white inner-header pt-40 pb-25">
    <div class="container-fluid">
        <nav>
            <div class="d-flex justify-content-between">
                <div class="">
                    <a href="<?=toRoute('/')?>" class="d-flex align-items-center">
                        <img src="/img/logo-alt.svg" width="48" alt="" class="logo__img">
                        <div class="logo__text"><?= t("Электронный информационно-интерактивный торговый<br>портал по кластеру медной промышленности") ?></div>
                    </a>
                </div>
                <div class=" d-flex align-items-center flex-shrink-0">
                    <ul>
                        <li>
                            <a href="<?= toRoute('/') ?>"><?= t("Главная") ?></a>
                        </li>
                        <?php foreach ($pages as $page) : ?>
                            <li>
                                <a href="<?= toRoute('/pages/' . $page->url) ?>"><?= $page->title ?></a>
                            </li>
                        <?php endforeach ?>
                        <li>
                            <?= \frontend\widgets\WLang::widget() ?>
                        </li>
                        <li>
                            <a href="#!" onclick="window.swiper.slideTo(2)" class="trades">
                                <?= t("Торги") ?>
                            </a>
                        </li>
                        <li class="profile-link nav-item dropdown dropdown--profile">
                            <?php if (Yii::$app->user->isGuest) : ?>
                                <a class="nav-link d-flex align-items-center cabinet-btn" href="<?= toRoute('/site/login') ?>">
                                    <img src="/img/user.svg" alt="">
                                    <div>
                                        <div class="top">
                                            <?= t("Личный кабинет") ?>
                                        </div>
                                        <div class="bottom">
                                            <?= t("Войти") ?>
                                        </div>
                                    </div>
                                </a>
                            <?php else : ?>
                                <?php $company = Company::findOne(Yii::$app->user->identity->company_id); ?>
                                <a href="#!" class="nav-link d-inline-flex align-items-center dropdown-toggle" role="button" id="dropdownProfileLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="/img/user.svg" alt="">
                                    <div>
                                        <div class="top">
                                            <?= t("Личный кабинет") ?>
                                        </div>
                                    </div>
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
        </nav>
    </div>
</header>