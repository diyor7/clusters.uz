<?php

use common\models\Page;

$pages = Page::findAll(['type' => Page::TYPE_MAIN, 'status' => Page::STATUS_ACTIVE]);

?>

<footer class="new">
    <div class="container">
        <div class="d-flex w-100 justify-content-between">
            <a href="<?= toRoute('/') ?>">
                <div class="d-flex new-logo align-items-center">
                    <div class="mr-3 w-10">
                        <img src="/img/logo/logo.svg" alt="">
                    </div>
                    <div class="new-logo-text">
                        <span class="first"><?= t("Информационно-интерактивный торговый портал") ?></span>
                        <span class="last"><?= t("кластера медной промышленности") ?></span>
                    </div>
                </div>
            </a>
            <div>
<!--                <img class="mr-4" src="/img/google-store.png" alt="">-->
<!--                <img src="/img/apple-store.png" alt="">--> 
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
                <li><a href="<?= toRoute('/page/news') ?>"><?= t("Новости") ?></a></li>
<!--                <li><a href="--><?//= toRoute('/page/documents') ?><!--">--><?//= t("Нормативно-правовая база") ?><!--</a></li>-->
                <li><a href="<?=toRoute(['/instruction'])?>"><?= t("Инструкция") ?></a></li>
                <li><a href="<?= toRoute('/page/contact') ?>"><?= t("Контакты") ?></a></li>
                <!-- <li><a href="https://t.me/+NRKYLiDkoiA0NGYy"><?= t("Поддерживать") ?></a></li> -->
            </ul>
        </nav>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex justify-content-between infos">
                    <div class="info ">
                        <?=t("При использовании материалов сайта ссылка на веб-сайт clusters.uz обязательна.")?>
                    </div>
                    <div class="info "><?=t("Внимание! Если Вы нашли ошибку в тексте, выделите её и нажмите Ctrl+Enter для уведомления администрации.")?></div>
                    <div class="info ">
                        <p>ИНН: <b>308792441</b></p>
                        <p>МФО: <b>00419</b></p>
                        <p>Р/с: <b>20210000305520414001</b></p>
                        <p>Адрес: <b>ул. Ислама Каримова, 45а, Ташкент, Узбекистан 100003</b></p>
                        <p></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="copyright text-center">
                © <?=t("Все права защищены ") . date('Y')?>
        </div>

    </div>
</div>
