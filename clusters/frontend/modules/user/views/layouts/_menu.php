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
        <a class="<?= $this->context->route == 'user/profile/index' ? 'active' : '' ?>" href="<?= toRoute('/user') ?>">
            <img src="/img/sidebar-1.svg">
            <span>
                <?= t("Личные данные") ?>
            </span>
        </a>
    </li>
    <?php if ($type != Company::TYPE_PHYSICAL) : ?>
    <li class="">
        <a class="<?= $this->context->route == 'user/requisite/index' ? 'active' : '' ?>"
            href="<?= toRoute('/user/requisite') ?>">
            <img src="/img/sidebar-2.svg">
            <span>
                <?= t("Реквизиты") ?>
            </span>
        </a>
    </li>
    <li class="">
        <a class="<?= $this->context->route == 'user/balance/index' ? 'active' : '' ?>"
            href="<?= toRoute('/user/balance') ?>">
            <img src="/img/sidebar-3.svg">
            <span>
                <?= t("Баланс") ?>
            </span>
        </a>
    </li>
    <?php endif ?>
    <?php if ($type == Company::TYPE_PHYSICAL) : ?>
    <li class="">
        <a class="<?= $this->context->route == 'user/order/index' || $this->context->route == 'user/order/view' ? 'active' : '' ?>"
            href="<?= toRoute('/user/order') ?>">
            <img src="/img/sidebar-4.svg">
            <span>
                <?= t("Мои заказы") ?>
            </span>
        </a>
    </li>
    <?php else : ?>
    <li class="">
        <a class="<?= in_array($this->context->route, ['user/request/index', 'user/request/waiting', 'user/request/finished', 'user/request/cancelled', 'user/request/view']) ? 'active' : '' ?>"
            href="<?= toRoute('/user/request') ?>">
            <img src="/img/sidebar-5.svg">
            <span>
                <?= t("Запросы цен") ?>
            </span>
        </a>
    </li>
    <li class="">
        <a class="<?= in_array($this->context->route, ['user/contract/index', 'user/contract/waiting', 'user/contract/delivered', 'user/contract/processing', 'user/contract/cancelled', 'user/contract/view']) ? 'active' : '' ?>"
            href="<?= toRoute('/user/contract') ?>">
            <img src="/img/sidebar-6.svg">
            <span>
                <?= t("Договора") ?>
            </span>
        </a>
    </li>
    <?php endif ?>
    <li class="">
        <a class="<?= $this->context->route == 'user/favorite/index' ? 'active' : '' ?>"
            href="<?= toRoute('/user/favorite') ?>">
            <img src="/img/sidebar-7.svg">
            <span>
                <?= t("Избранные") ?>
            </span>
        </a>
    </li>
    <li class="">
        <a class="<?= $this->context->route == 'user/address/index' || $this->context->route == 'user/address/handle' ? 'active' : '' ?>"
            href="<?= toRoute('/user/address') ?>">
            <img src="/img/sidebar-1.svg">
            <span>
                <?= t("Адрес") ?>
            </span>
        </a>
    </li>
    <li class="">
        <a class="<?= $this->context->route == 'user/notification/index' ? 'active' : '' ?>"
            href="<?= toRoute('/user/notification') ?>">
            <img src="/img/sidebar-8.svg">
            <span>
                <?= t("Уведомления") ?>
            </span>
            <?php if ($notification_count > 0) : ?>
            <span class="badge badge-danger"><?= $notification_count ?></span>
            <?php endif ?>
        </a>
    </li>

    <li class="">
        <?php $activateClass = (in_array($this->context->route, ['user/auction/my-trades','user/auction/my-lots', ]))?>
        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed <?= $activateClass ? 'active' : '' ?> py-15">
            <img src="/img/sidebar-4.svg">
            <span>
                <?= t("Мои сделки") ?>
            </span>
        </a>
        <ul class="collapse pl-30 pt-20 <?= $activateClass ? 'show' : '' ?>" id="pageSubmenu">
            <li class="mb-15 nav-link">
                <a href="<?= toRoute('/user/auction/my-trades') ?>" class="<?=$this->context->route == 'user/auction/my-trades' ? 'active' : ''?>"><?= t("Мои сделки") ?></a>
            </li>
            <li class="mb-15 nav-link">
                <a href="<?= toRoute('/user/auction/my-lots') ?>" class="<?=$this->context->route == 'user/auction/my-lots' ? 'active' : ''?>"><?= t("Мои лоты") ?></a>
            </li>
        </ul>

    </li>
    
    <li class="">
        <a class="<?= $this->context->route == 'user/auction/add' ? 'active' : '' ?>"
            href="<?= toRoute('/user/auction/add') ?>">
            <img src="/img/sidebar-6.svg">
            <span>
                <?= t("Размещение аукциона") ?>
            </span>

        </a>
    </li>
    <li class="">
        <a class="<?= $this->context->route == 'user/procurement-plans/index' || $this->context->route == 'user/procurement-plans/create' ? 'active' : '' ?>"
            href="<?= toRoute('/user/procurement-plans') ?>">
            <img src="/img/sidebar-7.svg">
            <span>
                <?= t("План закупок") ?>
            </span>
        </a>
    </li>
    <?php if (in_array($user->company->tin, Yii::$app->params['inn'])) : ?>
    <li class="">
        <a class=" <?= $this->context->route == 'cabinet/notification/index' ? 'active' : '' ?>"
            href="<?= toRoute('/crm') ?>">
            <img src="/img/sidebar-7.svg">
            <span>
                <?= t("Данные кластера") ?>
            </span>
        </a>
    </li>
    <?php endif ?>
</ul>