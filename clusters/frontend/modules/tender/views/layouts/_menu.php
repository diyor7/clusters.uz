<?php

use common\models\Company;
use common\models\Notification;
use common\models\User;

$user = User::findOne(Yii::$app->user->id);
$notification_count = Notification::find()->where(['user_id' => Yii::$app->user->id, 'is_read' => 0])->count();
$type = $user ? $user->companyType : Company::TYPE_PHYSICAL;

$platform_type = Yii::$app->session->get("platform_type");
?>
<div class="d-navigation">
    <div class="container-fluid">
        <ul class="nav fs-15">
            <li class="nav-item ml-n15">
                <a class="nav-link <?= $this->context->route == 'auction/default/index' ? 'active' : '' ?> py-15" href="<?= toRoute('/auction') ?>">
                    <?= t("Список лотов") ?>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= $this->context->route == 'auction/default/add' ? 'active' : '' ?> py-15" href="<?= toRoute('/auction/default/add') ?>">
                    <?= t("Размещение") ?>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= $this->context->route == 'auction/default/my-lots' ? 'active' : '' ?> py-15" href="<?= toRoute('/auction/default/my-lots') ?>">
                    <?= t("Мои лоты") ?>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= $this->context->route == 'auction/default/my-trades' ? 'active' : '' ?> py-15" href="<?= toRoute('/auction/default/my-trades') ?>">
                    <?= t("Мои сделки") ?>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link py-15" href="<?= toRoute('/site/logout') ?>" data-method="POST">
                    <?= t("Выйти") ?>
                </a>
            </li>
        </ul>
    </div>
</div>