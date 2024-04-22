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
        <a class=" <?= $this->context->route == 'cabinet/profile/index' ? 'active' : '' ?> py-15" href="<?= toRoute('/cabinet') ?>">
            <img src="/img/sidebar-1.svg">
            <span>
                <?= t("Личные данные") ?>
            </span>
        </a>
    </li>
    <li class="">
        <a class=" <?= in_array($this->context->route, ['cabinet/product/handle', 'cabinet/product/archive', 'cabinet/product/index', 'cabinet/product/moderating', 'cabinet/product/not-moderated', 'cabinet/product/tn']) ? 'active' : '' ?> py-15" href="<?= toRoute('/cabinet/product') ?>">
            <img src="/img/sidebar-7.svg">
            <span>
                <?= t("Мои товары") ?>
            </span>
        </a>
    </li>
    <li class="">
        <a class=" <?= $this->context->route == 'cabinet/requisite/index' ? 'active' : '' ?> py-15" href="<?= toRoute('/cabinet/requisite') ?>">
            <img src="/img/sidebar-2.svg">
            <span>
                <?= t("Реквизиты") ?>
            </span>
        </a>
    </li>
    <li class="">
        <a class=" <?= $this->context->route == 'cabinet/balance/index' ? 'active' : '' ?> py-15" href="<?= toRoute('/cabinet/balance') ?>">
            <img src="/img/sidebar-3.svg">
            <span>
                <?= t("Баланс") ?>
            </span>
        </a>
    </li>
    <li class="">
        <a class=" <?= $this->context->route == 'cabinet/order/index' || $this->context->route == 'cabinet/order/update' || $this->context->route == 'cabinet/order/view' ? 'active' : '' ?> py-15" href="<?= toRoute('/cabinet/order') ?>">
            <img src="/img/sidebar-4.svg">
            <span>
                <?= t("Заказы") ?>
            </span>
        </a>
    </li>
    <li class="">
        <a class=" <?= in_array($this->context->route, ['cabinet/request/index', 'cabinet/request/waiting', 'cabinet/request/finished', 'cabinet/request/cancelled', 'cabinet/request/view']) ? 'active' : '' ?> py-15" href="<?= toRoute('/cabinet/request') ?>">
            <img src="/img/sidebar-5.svg">
            <span>
                <?= t("Запросы цен") ?>
            </span>
        </a>
    </li>
    <li class="">
        <a class=" <?= in_array($this->context->route, ['cabinet/contract/index', 'cabinet/contract/waiting', 'cabinet/contract/delivered', 'cabinet/contract/processing', 'cabinet/contract/cancelled', 'cabinet/contract/view']) ? 'active' : '' ?> py-15" href="<?= toRoute('/cabinet/contract') ?>">
            <img src="/img/sidebar-6.svg">
            <span>
                <?= t("Договора") ?>
            </span>
        </a>
    </li>
    <li class="">
        <a class=" <?= $this->context->route == 'cabinet/notification/index' ? 'active' : '' ?>" href="<?= toRoute('/cabinet/notification') ?>">
            <img src="/img/sidebar-8.svg">
            <span>
                <?= t("Уведомления") ?>
            </span>
            <?php if ($notification_count > 0) : ?>
                <span class="badge badge-danger"><?= $notification_count ?></span>
            <?php endif ?>
        </a>
    </li>
</ul>