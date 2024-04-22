<?php

use common\models\Auction;
use yii\bootstrap\ActiveForm;

$this->title = t("Лот #") . $model->id;

$this->params['breadcrumbs'][] = array(
    'label' => t("Список лотов"),
    'url' => toRoute('/auction')
);
$this->params['breadcrumbs'][] = $this->title;
?>

<?= ''; //$this->render("../layouts/_menu") 
?>

<div class="new-bg-different">
    <div class="container py-30">
        <div class="d-flex align-items-start">
            <div class="mr-20">
                <img src="/img/newplatform3.png" alt="">
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
            <a href="<?= toRoute('/auction') ?>">Аукцион</a>
            <span></span>
            <p><?= $this->title ?></p>
        </div>
    </div>
</div>

<div class="container mb-30">
    <div class="row">
        <div class="col-12">
            <div class=" bg-white  h-100 py-60">
                <h2 class="new-title-5 border-0">№ ЛОТА: <?= $model->id ?></h2>
                <h1 class="new-title-6"><?= $name ?></h1>

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
                                        <?= $auctionTn->quantity ?> <?= $auctionTn->unit->title ?>
                                    </div>
                                </div>
                                <div>
                                    <div class="label">Стартовая цена за единицу</div>
                                    <div class="value">
                                        <?= $auctionTn->price ?> <?= t("сум") ?>
                                    </div>
                                </div>
                                <div>
                                    <div class="label">Текущая предложенная цена</div>
                                    <div class="value">
                                        <?php if ($model->total_sum === $model->currentPrice) : ?>
                                            <?= t("Пока не подана") ?>
                                        <?php else : ?>
                                            <?= $auctionTn->price * ($model->currentPrice / $model->total_sum) ?> <?= t("сум") ?>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div>
                                    <div class="label">Следующая цена</div>
                                    <div class="value">
                                        <?= $auctionTn->price * ($model->currentPrice / $model->total_sum - 0.02) ?> <?= t("сум") ?>
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

                </div>

                <div class=" ">
                    <div class="d-doc__products p-30">
                        <div class="fs-16 fw-semi-bold mb-20 text-uppercase"><?= t("Продукты заказа") ?>:</div>
                        <div class="table-responsive">
                            <table class="table mb-0 fs-15">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th class="text-center"><?=t("Код ТН ВЭД")?></th>
                                        <th class="text-center"><?= t("Количество") ?></th>
                                        <th class="text-center"><?= t("Цена") ?></th>
                                        <th class="text-right"><?= t("Сумма") ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($model->auctionTns as $index => $model_list) : ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td class="text-left"><?= $model_list->tn->title ?></td>
                                            <td class="text-center whitespace-nowrap"><?= $model_list->quantity ?></td>
                                            <td class="text-center whitespace-nowrap"><?= showPrice($model_list->price) ?> <?= t("сум") ?></td>
                                            <td class="text-right whitespace-nowrap"><?= showPrice($model_list->quantity * $model_list->price) ?> <?= t("сум") ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-doc__products p-30">
                        <div class="fs-16 fw-semi-bold mb-20 text-uppercase"><?= t("Аукцион") ?>:</div>
                        <div class="table-responsive">
                            <table class="table mb-0 fs-15">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?= t("Итого стартовая стоимость") ?></th>
                                        <th class="text-center"><?= t("Текущая итоговая стоимость") ?></th>
                                        <th class="text-right"><?= t("Следующая итоговая стоимость") ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td class="text-center whitespace-nowrap"><?= showPrice($model->total_sum) ?> <?= t("сум") ?></td>
                                    <td class="text-center whitespace-nowrap"><?= showPrice($model->currentPrice) ?> <?= t("сум") ?></td>
                                    <td class="text-right whitespace-nowrap"><?= showPrice($model->currentPrice - $model->total_sum * 0.02) ?> <?= t("сум") ?></td>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <a href="<?= toRoute(["/auction/default/offer", 'id' => $model->id, 'price' => $model->nextPrice]) ?>" data-confirm="<?= t("Вы уверены что хотите снизить цену до {sum}", ["sum" => showPrice($model->currentPrice - $model->total_sum * 0.02) . ' ' . t("сум")]) ?>" class="btn btn-primary px-20 py-5 fs-15 mr-5">
                                <?= t("Предложить") ?>
                                <?= showPrice($model->currentPrice - $model->total_sum * 0.02) ?> <?= t("сум") ?>
                            </a>
                        </div>
                    </div>

                    <div class="d-doc__body p-30">
                        <div class="row">
                            <div class="col-6 col-xxl-8">
                                <div class="row mb-20 align-items-center">
                                    <div class="col-12">
                                        <div class="d-doc__total">
                                            <div class="d-doc__title"><?= t("Общая сумма") ?>:</div>
                                            <div class="d-doc__text d-doc-text--price fs-36 font-weight-bold">‭<?= showPrice($model->total_sum) ?> <?= t("сум") ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-doc__brand">
                                    <div class="d-doc__title mb-5"> <?= t("Ф.И.О. получателя") ?>:</div>
                                    <div class="d-doc__text">
                                        <b><?= $model->receiver_phone ?></b>
                                    </div>
                                    <div class="brand__details mt-30 fs-15">
                                        <div class="row">
                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Срок поставки") ?>:</div>
                                                    <div class="d-doc__text"><?= calculateInterval($model->delivery_period) ?> </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Телефон получателя") ?>:</div>
                                                    <div class="d-doc__text"><a href="tel:<?= $model->receiver_phone ?>" target="_blank" class="link--black"><?= $model->receiver_phone ?></a></div>
                                                </div>
                                            </div>

                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Адрес") ?>:</div>
                                                    <div class="d-doc__text"><?= $model->address ?></div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Срок оплаты") ?>:</div>
                                                    <div class="d-doc__text"><?= calculateInterval($model->payment_period) ?></div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Заказчик") ?>:</div>
                                                    <div class="d-doc__text"><?= $model->company ? $model->company->name : t("Удалён") ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-doc__text">
                                        <b><?= t("Тендер") ?></b>
                                    </div>

                                    <div class="brand__details mt-30 fs-15">
                                        <div class="row">
                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Статус") ?>:</div>
                                                    <div class="d-doc__text"><?= $model->statusName ?></div>
                                                </div>
                                            </div>
                                            <?php if ($model->status == Auction::STATUS_ACTIVE) : ?>
                                                <div class="col-xxl-6">
                                                    <div class="brand__detail mb-20 pl-20">
                                                        <div class="d-doc__title fw-semi-bold mb-5"><?= t("Дата окончания аукциона") ?>:</div>
                                                        <div class="d-doc__text"><?= $model->auction_end ? date("d.m.Y H:i:s", strtotime($model->auction_end)) : null ?></div>
                                                    </div>
                                                </div>
                                            <?php elseif ($model->status == Auction::STATUS_FINISHED) : ?>
                                                <div class="col-xxl-6">
                                                    <div class="brand__detail mb-20 pl-20">
                                                        <div class="d-doc__title fw-semi-bold mb-5"><?= t("Завершен в") ?>:</div>
                                                        <div class="d-doc__text"><?= $model->tender_end ? date("d.m.Y H:i:s", strtotime($model->tender_end)) : null ?></div>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Количество приведенных цен") ?>:</div>
                                                    <div class="d-doc__text"><?= count($model->auctionRequests) ?></div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Стартовая цена") ?>:</div>
                                                    <div class="d-doc__text"><?= showPrice($model->total_sum) ?> <?= t("сум") ?></div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Актуальная цена") ?>:</div>
                                                    <div class="d-doc__text"><?= showPrice($model->currentPrice) ?> <?= t("сум") ?></div>
                                                </div>
                                            </div>
                                            <?php if ($model->myRequest) : ?>
                                                <div class="col-xxl-6">
                                                    <div class="brand__detail mb-20 pl-20">
                                                        <div class="d-doc__title fw-semi-bold mb-5"><?= t("Мое предложение") ?>:</div>
                                                        <div class="d-doc__text"><?= showPrice($model->myRequest->price) ?> <?= t("сум") ?></div>
                                                    </div>
                                                </div>
                                            <?php endif ?>

                                            <?php if ($model->status == Auction::STATUS_ACTIVE) : ?>
                                                <?php if (!$model->myRequest) : ?>
                                                    <div class="col-xxl-6">
                                                        <div class="brand__detail mb-20 pl-20">
                                                            <div class="d-doc__title fw-semi-bold mb-5"><?= t("Общее количество товаров") ?>:</div>
                                                            <div class="d-doc__text"><?= ($model->getAuctionTns()->sum("quantity")) ?></div>
                                                        </div>
                                                    </div>

                                                <?php endif ?>
                                            <?php elseif ($model->status == Auction::STATUS_FINISHED) : ?>
                                                <div class="col-xxl-6">
                                                    <div class="brand__detail mb-20 pl-20">
                                                        <div class="d-doc__title fw-semi-bold mb-5"><?= t("Дата аукциона") ?>:</div>
                                                        <div class="d-doc__text"><?= $model->auction_end ? date("d.m.Y H:i", strtotime($model->auction_end)) : t("(не указано)") ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-6">
                                                    <div class="brand__detail mb-20 pl-20">
                                                        <div class="d-doc__title fw-semi-bold mb-5"><?= t("Количество приведенных цен") ?>:</div>
                                                        <div class="d-doc__text"><?= count($model->auctionRequests) ?></div>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-xxl-4">
                                <div class="d-doc__status">
                                    <div class="d-doc__title"><?= t("История заказа") ?>:</div>
                                    <ul class="status__time-line">
                                        <li>
                                            <div class="status__date-time mb-5"><b><?= date("d.m.Y", strtotime($model->created_at)) ?></b> <?= date("H:i", strtotime($model->created_at)) ?></div>
                                            <div class="status__text"><?= t("Аукцион создан") ?></div>
                                        </li>
                                        <?php if ($model->payment_date) : ?>
                                            <li class="status__do">
                                                <div class="status__date-time mb-5"><b><?= date("d.m.Y", strtotime($model->payment_date)) ?></b> <?= date("H:i", strtotime($model->payment_date)) ?></div>
                                                <div class="status__text"><?= t("Платёж принят") ?></div>
                                            </li>
                                        <?php endif ?>
                                        <?php if ($model->auction_end) : ?>
                                            <li class="status__do">
                                                <div class="status__date-time mb-5"><b><?= date("d.m.Y", strtotime($model->auction_end)) ?></b> <?= date("H:i", strtotime($model->auction_end)) ?></div>
                                                <div class="status__text"><?= t("Завершение тендера") ?></div>
                                            </li>
                                        <?php endif ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>