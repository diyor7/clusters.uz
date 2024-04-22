<?php

use common\models\Company;

$this->title = t("Ваш заказ принят. Спасибо!");
?>

<div class="d-page__content px-40 bg-white py-150 text-center last_step_page my-100">
    <div class="container">
        <a>
            <img src="/img/check.svg">
        </a>

        <h3 class="black-text mt-30 mb-0 font-weight-bold fs-22"><?= $this->title ?></h3>
        <p class="mb-0 p-20 font-family-roboto gray-text-dark">
            <?= t("Номер вашего заказа") ?>
            <a class="font-weight-bold underline-text" href="<?= in_array($user->companyType, [Company::TYPE_BUDGET, Company::TYPE_COPERATE]) ? toRoute('/user/request/' . $order->id) : toRoute('/user/order/' . $order->id) ?>">№<?= $order->id ?>.</a>
        </p>
        <p class="mt-90 mb-0">
            <a class="underline-text gray-text" href="<?= toRoute('/') ?>"><?= t("Продолжить покупку") ?></a>
        </p>
    </div>
</div>