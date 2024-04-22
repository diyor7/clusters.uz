<?php

use common\models\User;

$user = User::findOne(Yii::$app->user->id);
?>

<div class="bg-white">
    <div class="container">
        <div class="new-cabinet-menu">
            <div class="row">
                <div class="col-md-3 w-100 d-flex align-items-center">
                    <div class="d-flex align-items-center w-100">
                        <a class="d-inline-block" href="<?= toRoute('/cabinet') ?>">
                            <img class="avatar" src="<?= $user->path ? $user->path : "/img/default-user.svg" ?>">
                        </a>
                        <div class="menu-title flex-grow-1">
                            <p><?= t("Кабинет поставщика") ?></p>
                            <a href="<?= toRoute('/site/logout') ?>" data-method="POST"><?= t("Выйти") ?></a>
                        </div>
                        <?php if ($user->type == User::TYPE_BOTH) : ?>
                            <a href="<?= toRoute('/user') ?>" class="text-right" title="<?= t("Перейти в Кабинет заказчика") ?>">
                                <img src="/img/reload.svg">
                            </a>
                        <?php endif ?>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h2 class="cabinet-title-1"><?= $this->title ?></h2>
                            <div class="cabinet-breadcrumb">
                                <a href="<?= toRoute('/') ?>"><?= t("Главная") ?></a>
                                <span>/</span>
                                <a href="<?= toRoute('/cabinet') ?>"><?= t("Кабинет поставщика") ?></a>
                                <span>/</span>

                                <?php if (isset($breadcrumb_title) && isset($breadcrumb_url)) : ?>
                                    <a href="<?= $breadcrumb_url ?>"><?= $breadcrumb_title ?></a>
                                    <span>/</span>
                                <?php endif ?>

                                <p><?= $this->title ?></p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <?php if (isset($btn_title) && isset($btn_url)) : ?>
                                <a href="<?= $btn_url ?>" class="btn btn-success"><?= $btn_title ?></a>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>