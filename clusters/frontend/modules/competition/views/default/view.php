<?php

use common\models\Auction;
use yii\bootstrap\ActiveForm;

$this->title = t("Лот #") . $model->id;

$this->params['breadcrumbs'][] = array(
    'label' => t("Список лотов"),
    'url' => toRoute('/competition')
);
$this->params['breadcrumbs'][] = $this->title;
?>

<?= ''; //$this->render("../layouts/_menu") 
?>

<div class="">
    <div class="container py-30">
        <div class="d-flex align-items-start">
            <div class="mr-20">
                <img src="/img/newplatform2.png" alt="">
            </div>
            <div>
                <h1 class="new-title-4 mb-0 pt-2">
                    <?= $this->title ?>
                </h1>
            </div>
        </div>

        <div class="new-breadcrumbs d-flex align-items-center">
            <a href="<?= toRoute('/') ?>"><?=t("Главная")?></a>
            <span></span>
            <a href="<?= toRoute('/competition') ?>">Электронный конкурс</a>
            <span></span>
            <p><?= $this->title ?></p>
        </div>
    </div>
</div>

<div class="new-bg-different pb-30">
    <div class="container ">
        <div class="row">
            <div class="col-12">
                <div class="  h-100 py-60">
                    <h2 class="new-title-5 border-0">№ ЛОТА: <?= $model->id ?></h2>
                    <h1 class="new-title-6"><?= $name ?></h1>

                    <div class="row">
                        <div class="col-lg-9">
                            <?php foreach ($model->auctionTns as $index => $auctionTn) : ?>
                                <div class="auction mt-25">
                                    <div class="content">
                                        <h4 class="new-title-5 border-0">№ <?= $index + 1 ?></h4>

                                        <h3 class="new-title-7"><?= $auctionTn->tn->title ?></h3>

                                        <p class="description">
                                            <?= $auctionTn->description ?>
                                        </p>
                                    </div>
                                    <div class="footer">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <div class="label">Количество товара</div>
                                                <div class="value">
                                                    <?= showQuantity($auctionTn->quantity) ?> <?= $auctionTn->unit->title ?>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="label">Стартовая цена за единицу</div>
                                                <div class="value">
                                                    <?= showPrice($auctionTn->price) ?> <?= t("сум") ?>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="label">Текущая предложенная цена</div>
                                                <div class="value">
                                                    <?php if ($model->total_sum === $model->currentPrice) : ?>
                                                        <?= t("Пока не подана") ?>
                                                    <?php else : ?>
                                                        <?= showPrice($auctionTn->price * ($model->currentPrice / $model->total_sum)) ?> <?= t("сум") ?>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="label">Следующая цена</div>
                                                <div class="value">
                                                    <?= showPrice($auctionTn->price * ($model->currentPrice / $model->total_sum - 0.02)) ?> <?= t("сум") ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>

                            <?php if (count($model->auctionConditions) > 0) : ?>
                                <div class="auction-conditions my-35">
                                    <div class="new-title-8">Особые условия</div>
                                    <ul>
                                        <?php foreach ($model->auctionConditions as $auctionCondition) : ?>
                                            <li>
                                                <img src="/img/new-check.svg" alt="">
                                                <?= $auctionCondition->condition->title ?>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            <?php endif ?>

                            <div class="auction-info my-40">
                                <div class="new-title-8">Информация о лоте и заказчике</div>
                                <table class="w-100 my-20">
                                    <tr>
                                        <th>ИНН:</th>
                                        <td><?= $model->company->tin ?></td>
                                    </tr>
                                    <tr>
                                        <th>Название организации:</th>
                                        <td><?= $model->company->name ?></td>
                                    </tr>
                                    <tr>
                                        <th>Адрес заказчика:</th>
                                        <td><?= $model->company->address ?></td>
                                    </tr>
                                    <tr>
                                        <th>Адрес доставки:</th>
                                        <td><?= $model->address ?></td>
                                    </tr>
                                    <tr>
                                        <th>Телефон:</th>
                                        <td><?= $model->company->phone ?></td>
                                    </tr>
                                    <tr>
                                        <th>Лицевой счет заказчика в казначействе:</th>
                                        <td><?= $model->company->companyBankAccount->account ?></td>
                                    </tr>
                                    <tr>
                                        <th>Условия поставки:</th>
                                        <td>Продавец осуществляет доставку</td>
                                    </tr>
                                    <tr>
                                        <th>Срок поставки (рабочих дней):</th>
                                        <td><?= $model->delivery_period ?></td>
                                    </tr>
                                    <tr>
                                        <th>Срок оплаты:</th>
                                        <td><?= $model->payment_period ?></td>
                                    </tr>
                                    <tr>
                                        <th>Залог (на следующую цену):</th>
                                        <td><?= showPrice($model->currentPrice * 0.1) ?> <?= t("сум") ?></td>
                                    </tr>
                                    <tr>
                                        <th>Сумма ком сбора (на следующую цену):</th>
                                        <td><?= showPrice($model->currentPrice * 0.01) ?> <?= t("сум") ?></td>
                                    </tr>
                                    <tr>
                                        <th>Дата начала:</th>
                                        <td><?= date("d.m.Y", strtotime($model->created_at)) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Дата окончания:</th>
                                        <td><?= date("d.m.Y H:i:s", strtotime($model->auction_end)) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Просмотры:</th>
                                        <td><?= $model->views ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="auction-action mt-25">
                                <h2>13:58:40</h2>
                                <p class="subtitle">Срок окончания</p>

                                <div class="label mt-30">
                                    Кол-во участников
                                </div>
                                <div class="value">
                                    <?= count($model->auctionRequests) + 0 ?>
                                </div>
                                <div class="label mt-30">
                                    Стартовая сумма
                                </div>
                                <div class="value">
                                    <?= showPrice($model->total_sum) ?> <?= t("сум") ?>
                                </div>
                                <div class="label mt-30">
                                    Текущая сумма
                                </div>
                                <div class="value">
                                    <?php if ($model->total_sum === $model->currentPrice) : ?>
                                        <?= t("Пока не подана") ?>
                                    <?php else : ?>
                                        <?= showPrice($model->currentPrice) ?> <?= t("сум") ?>
                                    <?php endif ?>
                                </div>
                                <div class="label mt-30">
                                    Следующая сумма
                                </div>
                                <div class="value">
                                    <?= showPrice($model->nextPrice) ?> <?= t("сум") ?>
                                </div>

                                <!-- <a href="#!" class="action mt-20 w-100 text-center" data-toggle="modal" data-target="#requestModal">Подать заявку</a> -->
                                <a href="<?= Yii::$app->user->isGuest ? toRoute('/site/login') : '#!' ?>" class="action mt-20 w-100 text-center">Подать заявку</a>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- 
<div class="modal" id="requestModal">
    <div class="modal-dialog request-modal modal-lg modal-dialog-centered">
        <div class="modal-body bg-white">
            <div class="text-right">
                <a class="cursor-pointer" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="/img/modal-close.svg" alt="">
                </a>
            </div>
            <h2>Вы действительно хотите отправить заявку на лот № <?= $model->id ?></h2>

            <table class="table w-100">
                <thead>
                    <tr>
                        <th>
                            Товар
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div> -->