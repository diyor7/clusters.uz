<?php

use common\models\Page;

$abouts = Page::findAll(['type' => Page::TYPE_FOOTER_ABOUT_US]);
$sellers = Page::findAll(['type' => Page::TYPE_FOOTER_FOR_SELLERS]);
$buyers = Page::findAll(['type' => Page::TYPE_FOOTER_FOR_BUYERS]);
$pages = Page::findAll(['type' => Page::TYPE_HEADER]);
?>

<footer class="home">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <a href="<?= toRoute('/') ?>" class="ml-0">
                    <?= t("Главная") ?>
                </a>
                <?php foreach ($pages as $page) : ?>
                    <a href="<?= toRoute('/pages/' . $page->url) ?>"><?= $page->title ?></a>
                <?php endforeach ?>
            </div>
            <div class="copyright">
                <?= t("Электронный информационно-интерактивный торговый портал по кластеру медной промышленности") ?> © <?= date("Y") ?>
            </div>
        </div>
    </div>
</footer>