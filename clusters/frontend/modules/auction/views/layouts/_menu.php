<?php

use common\models\Company;
use common\models\Notification;
use common\models\User;

$user = User::findOne(Yii::$app->user->id);
$notification_count = Notification::find()->where(['user_id' => Yii::$app->user->id, 'is_read' => 0])->count();
$type = $user ? $user->companyType : Company::TYPE_PHYSICAL;

$platform_type = Yii::$app->session->get("platform_type");
?>

<ul class="sidebar">
    <li class="">
        <a class="<?= $this->context->route == 'auction/default/index' ? 'active' : '' ?> py-15" href="<?= toRoute('/auction') ?>">
            <img src="/img/sidebar-1.svg">
            <span>
                <?= t("Список лотов") ?>
            </span>
        </a>
    </li>
    <li class="">
        <a class="<?= $this->context->route == 'auction/default/add' ? 'active' : '' ?> py-15" href="<?= toRoute('/auction/default/add') ?>">
            <img src="/img/sidebar-1.svg">
            <span>
                <?= t("Размещение") ?>
            </span>
        </a>
    </li>
    <li class="">
        <a class="<?= $this->context->route == 'auction/default/my-lots' ? 'active' : '' ?> py-15" href="<?= toRoute('/auction/default/my-lots') ?>">
            <img src="/img/sidebar-1.svg">
            <span>
                <?= t("Мои лоты") ?>
            </span>
        </a>
    </li>
    <li class="">
        <a class="<?= $this->context->route == 'auction/default/my-trades' ? 'active' : '' ?> py-15" href="<?= toRoute('/auction/default/my-trades') ?>">
            <img src="/img/sidebar-1.svg">
            <span>
                <?= t("Мои сделки") ?>
            </span>
        </a>
    </li>
    <li class="">
        <a class=" py-15" href="<?= toRoute('/site/logout') ?>" data-method="POST">
            <img src="/img/sidebar-1.svg">
            <span>
                <?= t("Выйти") ?>
            </span>
        </a>
    </li>
</ul>