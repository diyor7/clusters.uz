<?php

use common\models\Cart;
use common\models\Company;
use common\models\Page;
use common\models\User;

$pages = Page::findAll(['type' => Page::TYPE_MAIN, 'status' => Page::STATUS_ACTIVE]);

$user_type = Yii::$app->session->get("user_type", "customer");

$cart_data = Cart::getUserCartData();

?>
<nav class="new">
    <div class="container">
        <div class="d-flex w-100 justify-content-between">
            <div>
                <a href="tel:+998712326326"> <img src="/img/phone.svg">+99871 232 63 64</a>
            </div>
            <div class="d-flex align-items-center tools">
                <!-- <a href="#!" class="d-flex align-items-center tool">
                    <img src="/img/lupa.png" alt="">
                </a>
                <a href="#!" class="d-flex align-items-center tool">
                    <img src="/img/eye.png" alt="">
                </a> -->
                <a href="<?=toRoute(['/site/texnopark-application'])?>" style="color: #873F30"  class="d-flex align-items-center tool" title="<?= t('Заявление на прием в Технопарк "Ohangaron Tech Industrial"') ?>">
                    <?= t('Заявление на прием в Технопарк "Ohangaron Tech Industrial"') ?>
                </a>
                <a style="color: #873F30" href="<?=toRoute(['/purchases'])?>" class="d-flex align-items-center tool" title="<?= t("ЗАКУПКИ ПО ПЛОЩАДКАМ") ?>">
                    <?= t("Закупки по площадкам") ?>
                </a>
                <a href="<?=toRoute(['/instruction'])?>" class="d-flex align-items-center tool" title="<?= t("Инструкция") ?>">
                    <?= t("Инструкция") ?>
                </a>

                <!-- <a href="#!" style="color: #873F30" data-toggle="modal" data-target="#requestClusterModal"  class="d-flex align-items-center tool" title="<?= t("Заявление для участия в медном кластере") ?>">
                    <?=''// t("Заявление для участия в медном кластере") ?>
                </a> -->

                <?= \frontend\widgets\WLang::widget() ?>

                <?php if (Yii::$app->user->isGuest) : ?>
                    <a href="<?= toRoute('/site/login') ?>" class="d-flex align-items-center tool">
                        <span class="mr-2">
                            <?= t("Войти в систему") ?>
                        </span>
                        <img src="/img/user.png" alt="" class="d-block">
                    </a>
                <?php else : ?>
                    <div class="dropdown tool">
                        <?php $company = Company::findOne(Yii::$app->user->identity->company_id); ?>
                        <a class="dropdown-toggle" href="#!" role="button" id="dropdownProfileLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2">
                                <?= t("Кабинет") ?>
                            </span>
                            <img src="/img/user.png" alt="">
                        </a>
                        <div class="dropdown-menu p-20 fs-15 fw-semi-bold" aria-labelledby="dropdownProfileLink">
                            <div class="dropdown-user d-flex w-100 align-items-center mb-5 px-10">
                                <div class="dropdown-user__name fs-15 text-white"><?= t("ИНН") ?>: <?= $company->tin ?><br><span class="whitespace-nowrap"><?= $company->name ?></span></div>
                            </div>
                            <?php if (Yii::$app->user->identity->type == User::TYPE_CUSTOMER || Yii::$app->user->identity->type == User::TYPE_BOTH) : ?>
                                <a class="dropdown-item" href="<?= toRoute('/user') ?>"><?= t("Кабинет заказчика") ?></a>
                            <?php endif ?>
                            <?php if (Yii::$app->user->identity->type == User::TYPE_PRODUCER || Yii::$app->user->identity->type == User::TYPE_BOTH) : ?>
                                <a class="dropdown-item" href="<?= toRoute('/cabinet') ?>"><?= t("Кабинет поставщика") ?></a>
                            <?php endif ?>
                            <a class="dropdown-item" data-method="post" href="<?= toRoute('/site/logout') ?>"><?= t("Выйти") ?></a>
                        </div>
                    </div>
                <?php endif ?>

            </div>
        </div>
    </div>
</nav>

<div class="position-relative">
    <header class="new">
        <div class="container">
            <div class="d-flex w-100 justify-content-between align-items-center">
                <div>
                    <a href="<?= toRoute('/') ?>">
                        <div class="d-flex new-logo align-items-center">
                            <div class="w-10">
                                <img src="/img/logo/logo.svg" alt="">
                            </div>
                            <div class="new-logo-text">
                                <span class="first"><?= t("Информационно-интерактивный торговый портал") ?></span>
                                <span class="last"><?= t("кластера медной промышленности") ?></span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="d-flex justify-content-between align-items-center">

                </div>

                <div>
                    <a href="https://mineconomy.uz/ru" target="_blank">
                        <div class="d-flex new-logo align-items-center">
                            <div class="new-logo-text2 mr-3 text-right">
                                <?= t("Министерство экономического развития <br> и сокращения бедности") ?>
                            </div>
                            <div class="">
                                <img src="/img/iq-logo.svg" alt="">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="new-nav <?= isHome() ? '' : 'inner' ?>">
        <div class="container">
            <ul>
                <li><a href="<?= toRoute('/') ?>"><?= t("Главная") ?></a></li>

                <li>
                    <div class="dropdown tool">
                        <a class="dropdown-toggle" href="#!" role="button" id="dropdownProfileLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2">
                                <?= t("Страницы") ?>
                            </span>
                        </a>
                        <div class="dropdown-menu p-20 fs-15 fw-semi-bold" aria-labelledby="dropdownProfileLink">
                            <div class="d-flex w-100 align-items-center mb-5 px-0">
                                <div class="dropdown-user__name fs-15 text-white w-100">
                                    <a class="dropdown-item w-100" href="<?= toRoute('/page/contact') ?>"><?= t("Контакты") ?></a>
                                </div>
                            </div>

                            <div class="d-flex w-100 align-items-center mb-5 px-0">
                                <div class="dropdown-user__name fs-15 text-white w-100">
                                    <a class="dropdown-item w-100" href="<?= toRoute('/page/news') ?>"><?= t("Новости") ?></a>
                                </div>
                            </div>
                            <!-- <div class="d-flex w-100 align-items-center mb-5 px-0">
                                <div class="dropdown-user__name fs-15 text-white w-100">
                                    <a class="dropdown-item w-100" href="<?= toRoute('/page/conference') ?>"><?= t("Конференция") ?></a>
                                </div>
                            </div> -->

                        </div>
                    </div>
                </li>

                <?php
                    foreach ($pages as $page) : 
                    if(!($page->url == 'publichnaya-offerta' || $page->url == 'normative-acts')): 
                ?>
                    <li><a href="<?= toRoute('/pages/' . $page->url) ?>"><?= $page->title ?></a></li>
                    <?php endif; endforeach ?>
                <li><a href="<?= toRoute('/trade/index') ?>"><?= t("Закупки") ?></a></li>
                <li><a href="<?= toRoute('/store/produkcii-mednogo-remeslennichestva--2028') ?>"><?= t("Продукции медного ремесленничества") ?></a></li>
                <li><a href="<?= toRoute('/store/gorno-metallurgicheskie-tehniki--2029') ?>"><?= t("Горно-металлургические техники") ?></a></li>
            </ul>
        </div>

    </div>
</div>

<?=$this->render("_request_cluster_modal")?>
<?=$this->render("_conference_modal")?>
<?php
$this->registerJs('

',3)
?>
