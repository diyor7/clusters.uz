<?php

use common\models\Company;
use common\models\Page;

$pages = Page::findAll(['type' => Page::TYPE_HEADER]);

$user_type = Yii::$app->session->get("user_type", "customer");

?>
<!-- <marquee behavior="alternate" direction="right" style="position: fixed; top: 0; left: 0; width: 100%; color: #fff; font-size: 16px; font-weight: bolder; line-height: 150%; text-shadow: #000000 0px 1px 1px; z-index: 225; background-color: red">
    <?= t("Сайт работает в тестовом режиме.") ?>
</marquee> -->

<nav class="new">
    <div class="container-fluid">
        <div class="d-flex w-100 justify-content-between">
            <div>
                <a href="">О портале</a>
                <a href="">Новости</a>
                <a href="">Инструкция</a>
            </div>
            <div class="d-flex align-items-center">
                <?= \frontend\widgets\WLang::widget() ?>
                <a href="<?= toRoute('/site/login') ?>">
                    <img src="/img/nav-user.svg" alt="">
                    Войти в систему
                </a>
            </div>
        </div>
    </div>
</nav>
<header class="new">
    <div class="container-fluid">
        <div class="d-flex w-100 justify-content-between align-items-center">
            <div>
                <a href="<?= toRoute('/') ?>">
                    <div class="d-flex new-logo align-items-center">
                        <div class="mr-3">
                            <img src="/img/new-logo.svg" alt="">
                        </div>
                        <div class="new-logo-text">
                            Электронный информационно-интерактивный торговый<br>портал по кластеру медной промышленности
                        </div>
                    </div>
                </a>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="new-menu d-flex align-items-center mr-30 cursor-pointer">
                    <img src="/img/new-menu.svg" class="mr-3" alt="">
                    <span>Меню</span>
                </div>
                <div class="new-search d-flex align-items-center">
                    <div>
                        <input type="text" placeholder="Введите ключевое слово или номер извещения">
                    </div>
                    <div class="new-search-settings mr-4">
                        <img src="/img/new-search-settings.svg" alt="">
                        <span>Настройка поиска</span>
                    </div>
                    <div class="cursor-pointer">
                        <img src="/img/new-seach-icon.svg" alt="">
                    </div>
                </div>
            </div>

            <div>
                <a href="https://mineconomy.uz/ru" target="_blank">
                    <div class="d-flex new-logo align-items-center">
                        <div class="new-logo-text2 mr-3 text-right">
                            Министерство экономического развития <br>
                            и сокращения бедности
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