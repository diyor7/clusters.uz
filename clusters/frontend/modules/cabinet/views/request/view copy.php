<?php

use common\models\Order;
use yii\widgets\ActiveForm;

$this->title = t("Запрос цен") . " №" . $order->id;

$this->params['breadcrumbs'][] = array(
    'label' => t("Личный кабинет"),
    'url' => toRoute('/cabinet')
);

$this->params['breadcrumbs'][] = array(
    'label' => t("Запросы цен"),
    'url' => toRoute('/cabinet/request')
);

$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render("../layouts/_nav") ?>

<div class="new-bg-different py-30">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?= $this->render("../layouts/_menu") ?>
            </div>
            <div class="col-md-9">
                <div class="d-doc bg-white shadow rounded h-100">
                    <div class="d-doc__body p-30">
                        <div class="row">
                            <div class="col-6 col-xxl-8">
                                <div class="row mb-20 align-items-center">
                                    <div class="col-12">
                                        <div class="d-doc__total">
                                            <a class="" href="#!" onclick="window.print()">
                                                <i class="icon-printer"></i>
                                            </a>
                                            <div class="d-doc__title"><?= t("Общая сумма") ?>:</div>
                                            <div class="d-doc__text d-doc-text--price fs-36 font-weight-bold">‭<?= showPrice($order->total_sum) ?> <?= t("сум") ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-doc__brand">
                                    <div class="d-doc__title mb-5"> <?= t("Ф.И.О. получателя по паспорту") ?>:</div>
                                    <div class="d-doc__text">
                                        <b><?= $order->receiver_fio ?></b>
                                    </div>
                                    <div class="brand__details mt-30 fs-15">
                                        <div class="row">
                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Тип доставки") ?>:</div>
                                                    <div class="d-doc__text"><?= $order->deliveryType ?></div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Телефон получателя") ?>:</div>
                                                    <div class="d-doc__text"><a href="tel:<?= $order->receiver_phone ?>" target="_blank" class="link--black"><?= $order->receiver_phone ?></a></div>
                                                </div>
                                            </div>

                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Адрес") ?>:</div>
                                                    <div class="d-doc__text"><?= $order->address ? $order->address->text : $order->address_text ?></div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Тип оплаты") ?>:</div>
                                                    <div class="d-doc__text"><?= $order->paymentType ?></div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Плательщик") ?>:</div>
                                                    <div class="d-doc__text"><?= $order->user && $order->user->user_profile ? $order->user->user_profile->full_name : t("Удалён") ?></div>
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
                                                    <div class="d-doc__text"><?= $order->statusName ?></div>
                                                </div>
                                            </div>
                                            <?php if ($order->status == Order::STATUS_WAITING_ACCEPT) : ?>
                                                <div class="col-xxl-6">
                                                    <div class="brand__detail mb-20 pl-20">
                                                        <div class="d-doc__title fw-semi-bold mb-5"><?= t("Дата окончания удтверждения") ?>:</div>
                                                        <div class="d-doc__text"><?= $order->request_end ? date("d.m.Y H:i:s", strtotime($order->request_end)) : null ?></div>
                                                    </div>
                                                </div>
                                            <?php elseif ($order->status == Order::STATUS_REQUESTING) : ?>
                                                <div class="col-xxl-6">
                                                    <div class="brand__detail mb-20 pl-20">
                                                        <div class="d-doc__title fw-semi-bold mb-5"><?= t("Дата окончания") ?>:</div>
                                                        <div class="d-doc__text"><?= $order->tender_end ? date("d.m.Y H:i:s", strtotime($order->tender_end)) : null ?></div>
                                                    </div>
                                                </div>
                                            <?php elseif ($order->status == Order::STATUS_SELECTED_PRODUCER) : ?>
                                                <div class="col-xxl-6">
                                                    <div class="brand__detail mb-20 pl-20">
                                                        <div class="d-doc__title fw-semi-bold mb-5"><?= t("Дата торга") ?>:</div>
                                                        <div class="d-doc__text"><?= $order->tender_end ? date("d.m.Y H:i:s", strtotime($order->tender_end)) : null ?></div>
                                                    </div>
                                                </div>
                                            <?php endif ?>

                                            <?php if ($order->status == Order::STATUS_REQUESTING || $order->status == Order::STATUS_SELECTED_PRODUCER) : ?>
                                                <div class="col-xxl-6">
                                                    <div class="brand__detail mb-20 pl-20">
                                                        <div class="d-doc__title fw-semi-bold mb-5"><?= t("Количество приведенных цен") ?>:</div>
                                                        <div class="d-doc__text"><?= count($order->orderRequests) ?></div>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Стартовая цена") ?>:</div>
                                                    <div class="d-doc__text"><?= showPrice($order->total_sum) ?> <?= t("сум") ?></div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Актуальная цена") ?>:</div>
                                                    <div class="d-doc__text"><?= showPrice($order->actual_price) ?> <?= t("сум") ?></div>
                                                </div>
                                            </div>
                                            <?php if ($order->myRequest) : ?>
                                                <div class="col-xxl-6">
                                                    <div class="brand__detail mb-20 pl-20">
                                                        <div class="d-doc__title fw-semi-bold mb-5"><?= t("Мое предложение") ?>:</div>
                                                        <div class="d-doc__text"><?= showPrice($order->myRequest->price) ?> <?= t("сум") ?></div>
                                                    </div>
                                                </div>
                                            <?php endif ?>

                                            <?php if ($order->status == Order::STATUS_WAITING_ACCEPT && $order->company_id == Yii::$app->user->identity->company_id) : ?>
                                                <?php
                                                $deposit_percentage = isset(Yii::$app->params['deposit_percentage']) ? Yii::$app->params['deposit_percentage'] : 3;
                                                $commission_percentage = isset(Yii::$app->params['commission_percentage']) ? Yii::$app->params['commission_percentage'] : 0.15;
                                                ?>
                                                <a class="btn btn-primary px-20 py-5 fs-15 mr-5" data-sign="true" data-tin="<?= $order->company->tin ?>" href="<?= toRoute('/cabinet/request/accept?id=' . $order->id) ?>" data-confirm="<?= t(
                                                                                                                                                                                                                                                                    "Вы точно хотите принять? Начнётся 48-часовой торг. Мы снимем с вашего баланса {currency} сум, {deposit_percentage}% в виде залога и {commission_percentage}% в виде комиссии от стартовой суммы.",
                                                                                                                                                                                                                                                                    [
                                                                                                                                                                                                                                                                        'currency' => showPrice($order->total_sum * ($deposit_percentage + $commission_percentage) / 100),
                                                                                                                                                                                                                                                                        'deposit_percentage' => $deposit_percentage,
                                                                                                                                                                                                                                                                        'commission_percentage' => $commission_percentage
                                                                                                                                                                                                                                                                    ]
                                                                                                                                                                                                                                                                ) ?>">
                                                    <?= t("Принять") ?>
                                                </a>
                                                <a class="btn btn-outline-danger rounded-pill px-20 py-5 fs-15 mr-5" data-sign="true" data-tin="<?= $order->company->tin ?>" data-confirm="<?= t("Вы точно хотите отказать?") ?>" href="<?= toRoute('/cabinet/request/cancel?id=' . $order->id) ?>"><?= t("Отказать") ?></a>
                                            <?php elseif ($order->status == Order::STATUS_REQUESTING) : ?>
                                                <?php if (!$order->myRequest) : ?>
                                                    <div class="col-xxl-6">
                                                        <div class="brand__detail mb-20 pl-20">
                                                            <div class="d-doc__title fw-semi-bold mb-5"><?= t("Общее количество товаров") ?>:</div>
                                                            <div class="d-doc__text"><?= ($order->getOrderLists()->sum("quantity")) ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-6">
                                                        <?php $form = ActiveForm::begin() ?>
                                                        <div class="form-group">
                                                            <?= $form->field($model, 'price')->input("number", ['placeholder' => t("Предложить цену")]) ?>
                                                        </div>
                                                        <button type="submit" data-sign="true" data-tin="<?= $order->company->tin ?>" data-confirm="<?= t("Вы уверены?") ?>" class="btn btn-primary px-20 py-5 fs-15 mr-5"><?= t("Предложить") ?></button>
                                                        <?php ActiveForm::end() ?>
                                                    </div>
                                                <?php endif ?>
                                            <?php elseif ($order->status == Order::STATUS_SELECTED_PRODUCER) : ?>
                                                <div class="col-xxl-6">
                                                    <div class="brand__detail mb-20 pl-20">
                                                        <div class="d-doc__title fw-semi-bold mb-5"><?= t("Дата торга") ?>:</div>
                                                        <div class="d-doc__text"><?= $order->tender_end ? date("d.m.Y H:i", strtotime($order->tender_end)) : t("(не указано)") ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-6">
                                                    <div class="brand__detail mb-20 pl-20">
                                                        <div class="d-doc__title fw-semi-bold mb-5"><?= t("Количество приведенных цен") ?>:</div>
                                                        <div class="d-doc__text"><?= count($order->orderRequests) ?></div>
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
                                            <div class="status__date-time mb-5"><b><?= date("d.m.Y", strtotime($order->created_at)) ?></b> <?= date("H:i", strtotime($order->created_at)) ?></div>
                                            <div class="status__text"><?= t("Заказ принят") ?></div>
                                        </li>
                                        <?php if ($order->payment_date) : ?>
                                            <li class="status__do">
                                                <div class="status__date-time mb-5"><b><?= date("d.m.Y", strtotime($order->payment_date)) ?></b> <?= date("H:i", strtotime($order->payment_date)) ?></div>
                                                <div class="status__text"><?= t("Платёж принят") ?></div>
                                            </li>
                                        <?php endif ?>
                                        <?php if ($order->tender_end) : ?>
                                            <li class="status__do">
                                                <div class="status__date-time mb-5"><b><?= date("d.m.Y", strtotime($order->tender_end)) ?></b> <?= date("H:i", strtotime($order->tender_end)) ?></div>
                                                <div class="status__text"><?= t("Завершение тендера") ?></div>
                                            </li>
                                        <?php endif ?>
                                    </ul>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="d-doc__foot border-top-1">
                        <div class="d-doc__products p-30">
                            <div class="fs-16 fw-semi-bold mb-20 text-uppercase"><?= t("Продукты заказа") ?>:</div>
                            <div class="table-responsive">
                                <table class="table mb-0 fs-15">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th><?= t("Товар") ?></th>
                                            <th class="text-center"><?=t("Код ТН ВЭД")?></th>
                                            <th class="text-center"><?= t("Количество") ?></th>
                                            <th class="text-center"><?= t("Цена") ?></th>
                                            <th class="text-right"><?= t("Сумма") ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($order->orderLists as $index => $order_list) : ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td>
                                                    <a class="font-weight-bold gray-text-dark font-family-roboto" href="<?= toRoute('/store/product/' . $order_list->product->url) ?>">
                                                        <img class="mr-4" src="<?= $order_list->product->path ?>" width="80px" alt="<?= $order_list->product->title ?>" title="<?= $order_list->product->title ?>">
                                                        <?= $order_list->product->title ?>
                                                    </a>
                                                </td>
                                                <td class="text-center">4015 190 00 0</td>
                                                <td class="text-center"><?= $order_list->quantity ?></td>
                                                <td class="text-center"><?= showPrice($order_list->price) ?> <?= t("сум") ?></td>
                                                <td class="text-right"><?= showPrice($order_list->quantity * $order_list->price) ?> <?= t("сум") ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>