<?php

use common\models\Page;

$abouts = Page::findAll(['type' => Page::TYPE_FOOTER_ABOUT_US]);
$sellers = Page::findAll(['type' => Page::TYPE_FOOTER_FOR_SELLERS]);
$buyers = Page::findAll(['type' => Page::TYPE_FOOTER_FOR_BUYERS]);
$pages = Page::findAll(['type' => Page::TYPE_HEADER]);
?>

<footer class="new">
    <div class="container-fluid">
        <div class="d-flex w-100 justify-content-between">
            <div class="new-footer-menu d-flex align-items-center">
                <a href="<?= toRoute('/') ?>"><?=t("Главная")?></a>
                <a href="<?= toRoute('/') ?>">Юридические документы</a>
                <a href="<?= toRoute('/') ?>">Инструкция</a>
                <a href="<?= toRoute('/') ?>">Новости</a>
                <a href="<?= toRoute('/') ?>">Контакты</a>
            </div>
            <div>
                <img class="mr-4" src="/img/google-store.png" alt="">
                <img src="/img/apple-store.png" alt="">
            </div>
        </div>
    </div>
</footer>

<div class="new-copyright">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="d-flex align-items-center">
                <p class="m-0">
                    Электронный информационно-интерактивный торговый портал по кластеру медной промышленности
                </p>
            </div>
            <div>
                <img src="/img/socials.png" alt="">
            </div>
        </div>

    </div>
</div>