<?php

use common\models\Page;

$pages = Page::findAll(['type' => Page::TYPE_MAIN]);

?>

<footer class="new">
    <div class="container">
        <div class="d-flex w-100 justify-content-between">
            <a href="<?= toRoute('/') ?>">
                <div class="d-flex new-logo align-items-center">
                    <div class="mr-3">
                        <img src="/img/new-logo.svg" alt="">
                    </div>
                    <div class="new-logo-text">
                        <span class="first">Информационно-интерактивный торговый портал</span>
                        <span class="last">кластера медной промышленности</span>
                    </div>
                </div>
            </a>
            <div>
                <img class="mr-4" src="/img/google-store.png" alt="">
                <img src="/img/apple-store.png" alt="">
            </div>
        </div>
    </div>
</footer>

<div class="new-copyright">
    <div class="container">
        <nav>
            <ul>
                <?php foreach ($pages as $page) : ?>
                    <li><a href="<?= toRoute('/pages/' . $page->url) ?>"><?= $page->title ?></a></li>
                <?php endforeach ?>
                <li><a href=""><?= t("Новости") ?></a></li>
                <li><a href="<?= toRoute('/page/documents') ?>"><?= t("Нормативно-правовая база") ?></a></li>
                <li><a href=""><?= t("Инструкция") ?></a></li>
                <li><a href="<?= toRoute('/page/contact') ?>"><?= t("Контакты") ?></a></li>
            </ul>
        </nav>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex justify-content-between infos">
                    <div class="info w-50">При использовании материалов сайта ссылка на веб-сайт clusters.uz обязательна. </div>
                    <div class="info w-50">Внимание! Если Вы нашли ошибку в тексте, выделите её и нажмите Ctrl+Enter для уведомления администрации. </div>
                </div>
            </div>
        </div>

        <div class="copyright text-center">
            © Все права защищены 2021.
        </div>

    </div>
</div>