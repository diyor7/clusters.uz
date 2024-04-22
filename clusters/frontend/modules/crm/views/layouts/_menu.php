<?php

use common\models\Company;
use common\models\Notification;
use common\models\User;

$user = User::findOne(Yii::$app->user->id);
$notification_count = Notification::find()->where(['user_id' => Yii::$app->user->id, 'is_read' => 0])->count();
$type = $user ? $user->companyType : Company::TYPE_PHYSICAL;

//$platform_type = Yii::$app->session->get("platform_type");
$typeId = isset($this->context->actionParams['type_id'])?$this->context->actionParams['type_id']:null
?>
<ul class="sidebar">
    <li class="">
        <a class="<?= in_array($this->context->route, ['crm/crm-product','crm/crm-product/index', 'crm/crm-product/create', 'crm/crm-product/update', 'crm/crm-product/view']) ? 'active' : '' ?> py-15" href="<?= toRoute('/crm/crm-product') ?>">
            <img src="/img/sidebar-7.svg">
            <span>
                <?= t("Мои товары") ?>
            </span>
        </a>
    </li>
    <li class="">
        <?php $activateClass = (in_array($this->context->route, ['crm/crm-company-equipments','crm/crm-company-equipments/index', 'crm/crm-company-equipments/create', 'crm/crm-company-equipments/update', 'crm/crm-company-equipments/view', 'crm/crm-company-equipments-category','crm/crm-company-equipments-category/index', 'crm/crm-company-equipments-category/create', 'crm/crm-company-equipments-category/update', 'crm/crm-company-equipments-category/view']))?>
        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed <?= $activateClass ? 'active' : '' ?> py-15">
            <img src="/img/sidebar-1.svg">
            <span>
                <?= t("Оборудование") ?>
            </span>
        </a>
        <ul class="collapse pl-30 pt-20 <?= $activateClass ? 'show' : '' ?>" id="pageSubmenu">
            <li class="mb-15 nav-link">
                <a href="<?= toRoute('/crm/crm-company-equipments') ?>" class="<?=in_array($this->context->route, ['crm/crm-company-equipments/index','crm/crm-company-equipments/update','crm/crm-company-equipments/view'])?'active':''?>"><?=Yii::t('crm', 'Оборудование')?></a>
            </li>
            <li class="mb-15 nav-link">
                <a href="<?= toRoute('/crm/crm-company-equipments-category') ?>" class="<?=in_array($this->context->route, ['crm/crm-company-equipments-category/index','crm/crm-company-equipments-category/update','crm/crm-company-equipments-category/view'])?'active':''?>"><?=Yii::t('crm', 'Категории Оборудований')?></a>
            </li>
        </ul>

    </li>
    <li class="">
        <?php $activateClass = (in_array($this->context->route, ['crm/crm-mine','crm/crm-mine/index', 'crm/crm-mine/create', 'crm/crm-mine/update', 'crm/crm-mine/view','crm/crm-mining','crm/crm-mining/index', 'crm/crm-mining/create', 'crm/crm-mining/update', 'crm/crm-mining/view'])||$typeId == 1)?>

        <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed <?= $activateClass ? 'active' : '' ?> py-15">
            <img src="/img/sidebar-2.svg">
            <span>
                <?= t("Объемы ископаемых") ?>
            </span>
        </a>
        <ul class="collapse pl-30 pt-20 <?= $activateClass ? 'show' : '' ?>" id="pageSubmenu1">
            <li class="mb-15 nav-link">
                <a href="<?= toRoute('/crm/crm-mine') ?>" class="<?=in_array($this->context->route, ['crm/crm-mine/index','crm/crm-mine/update','crm/crm-mine/view'])?'active':''?>"><?=Yii::t('crm', 'Ископаемые')?></a>
            </li>
            <li class="mb-15 nav-link">
                <a href="<?= toRoute('/crm/crm-mining') ?>" class="<?=in_array($this->context->route, ['crm/crm-mining/index','crm/crm-mining/update','crm/crm-mining/view'])?'active':''?>"><?=Yii::t('crm', 'Добыча ископаемых')?></a>
            </li>
            <li class="mb-15 nav-link">
                <a href="<?= toRoute(['/crm/crm-equipments-used', 'type_id' => 1]) ?>" class="<?=in_array($this->context->route, ['crm/crm-equipments-used/index','crm/crm-equipments-used/view','crm/crm-equipments-used/update'])?'active':''?>">
                <?= t("Использованная техника") ?>
                </a>
            </li>
            <li class="mb-15 nav-link">
                <a href="<?= toRoute(['/crm/crm-workers-employed', 'type_id' => 1]) ?>" class="<?=in_array($this->context->route, ['crm/crm-workers-employed/index','crm/crm-workers-employed/view','crm/crm-workers-employed/update'])?'active':''?>">
                <?= t("Участвующие рабочие") ?>
                </a>
            </li>
        </ul>
    </li>

    <li class="">
        <?php $activateClass = (in_array($this->context->route, ['crm/crm-cargo-volumes','crm/crm-cargo-volumes/index', 'crm/crm-cargo-volumes/create', 'crm/crm-cargo-volumes/update', 'crm/crm-cargo-volumes/view']) ||$typeId == 3)?>
        <a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed <?= $activateClass ? 'active' : '' ?> py-15">
            <img src="/img/sidebar-4.svg">
            <span>
                <?= t("Логистика") ?>
            </span>
        </a>
        <ul class="collapse pl-30 pt-20 <?= $activateClass ? 'show' : '' ?>" id="pageSubmenu2">
            <li class="mb-15 nav-link">
                <a href="<?= toRoute('/crm/crm-cargo-volumes') ?>" class="<?=in_array($this->context->route, ['crm/crm-cargo-volumes/index','crm/crm-cargo-volumes/update','crm/crm-cargo-volumes/view'])?'active':''?>"><?=Yii::t('crm', 'Объемы грузов')?></a>
            </li>
            <li class="mb-15 nav-link">
                <a href="<?= toRoute(['/crm/crm-equipments-used', 'type_id' => 3]) ?>" class="<?=in_array($this->context->route, ['crm/crm-equipments-used/index','crm/crm-equipments-used/view','crm/crm-equipments-used/update'])?'active':''?>">
                <?= t("Использованная техника") ?>
                </a>
            </li>
            <li class="mb-15 nav-link">
                <a href="<?= toRoute(['/crm/crm-workers-employed', 'type_id' => 3]) ?>" class="<?=in_array($this->context->route, ['crm/crm-workers-employed/index','crm/crm-workers-employed/view','crm/crm-workers-employed/update'])?'active':''?>">
                <?= t("Участвующие рабочие") ?>
                </a>
            </li>
        </ul>
    </li>

    <li class="">
        <?php $activateClass = (in_array($this->context->route, ['crm/crm-production-volumes','crm/crm-production-volumes/index', 'crm/crm-production-volumes/create', 'crm/crm-production-volumes/update', 'crm/crm-production-volumes/view']) ||$typeId == 2)?>
        <a href="#pageSubmenu3" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed <?= $activateClass ? 'active' : '' ?> py-15">
            <img src="/img/sidebar-4.svg">
            <span>
                <?= t("Объемы производства") ?>
            </span>
        </a>
        <ul class="collapse pl-30 pt-20 <?= $activateClass ? 'show' : '' ?>" id="pageSubmenu3">
            <li class="mb-15 nav-link">
                <a href="<?= toRoute('/crm/crm-production-volumes') ?>" class="<?=in_array($this->context->route, ['crm/crm-production-volumes/index','crm/crm-production-volumes/view','crm/crm-production-volumes/update'])?'active':''?>"><?=Yii::t('crm', 'Объемы производства')?></a>
            </li>
            <li class="mb-15 nav-link">
                <a href="<?= toRoute(['/crm/crm-equipments-used', 'type_id' => 2]) ?>" class="<?=in_array($this->context->route, ['crm/crm-equipments-used/index','crm/crm-equipments-used/view','crm/crm-equipments-used/update'])?'active':''?>">
                <?= t("Использованная техника") ?>
                </a>
            </li>
            <li class="mb-15 nav-link">
                <a href="<?= toRoute(['/crm/crm-workers-employed', 'type_id' => 2]) ?>" class="<?=in_array($this->context->route, ['crm/crm-workers-employed/index','crm/crm-workers-employed/view','crm/crm-workers-employed/update'])?'active':''?>">
                <?= t("Участвующие рабочие") ?>
                </a>
            </li>
        </ul>
    </li>

    <li class="">
        <?php $activateClass =(in_array($this->context->route, ['crm/crm-wharehouse-iel','crm/crm-wharehouse-iel/index', 'crm/crm-wharehouse-iel/create', 'crm/crm-wharehouse-iel/update', 'crm/crm-wharehouse-iel/view'])||$typeId == 4) ?>
        <a href="#pageSubmenu4" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed <?= $activateClass ? 'active' : '' ?> py-15">
            <img src="/img/sidebar-4.svg">
            <span>
                <?= t("Склад") ?>
            </span>
        </a>
        <ul class="collapse pl-30 pt-20 <?= $activateClass ? 'show' : '' ?>" id="pageSubmenu4">
            <li class="mb-15 nav-link">
                <a href="<?= toRoute('/crm/crm-wharehouse-iel') ?>" class="<?=in_array($this->context->route, ['crm/crm-wharehouse-iel/index','crm/crm-wharehouse-iel/view','crm/crm-wharehouse-iel/update'])?'active':''?>"><?=Yii::t('crm', 'Склад импорт,Экспорт,локал')?></a>
            </li>
            <li class="mb-15 nav-link">
                <a href="<?= toRoute(['/crm/crm-equipments-used', 'type_id' => 4]) ?>" class="<?=in_array($this->context->route, ['crm/crm-equipments-used/index','crm/crm-equipments-used/view','crm/crm-equipments-used/update'])?'active':''?>">
                    <?= t("Использованная техника") ?>
                </a>
            </li>
            <li class="mb-15 nav-link">
                <a href="<?= toRoute(['/crm/crm-workers-employed', 'type_id' => 4]) ?>" class="<?=in_array($this->context->route, ['crm/crm-workers-employed/index','crm/crm-workers-employed/view','crm/crm-workers-employed/update'])?'active':''?>">
                    <?= t("Участвующие рабочие") ?>
                </a>
            </li>
        </ul>
    </li>
    <li class="">
        <a class="<?= in_array($this->context->route, ['crm/crm-employee-activity-type','crm/crm-employee-activity-type/index', 'crm/crm-employee-activity-type/create', 'crm/crm-employee-activity-type/update', 'crm/crm-employee-activity-type/view']) ? 'active' : '' ?> py-15" href="<?= toRoute('/crm/crm-employee-activity-type') ?>">
            <img src="/img/sidebar-7.svg">
            <span>
                <?= t("Вид деятельности сотрудника") ?>
            </span>
        </a>
    </li>


</ul>