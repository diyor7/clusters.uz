<?php
$this->title = t("Заказ") . " №" . $order->id;

$this->params['breadcrumbs'][] = array(
    'label' => t("Личный кабинет"),
    'url' => toRoute('/cabinet')
);

$this->params['breadcrumbs'][] = array(
    'label' => t("Заказы"),
    'url' => toRoute('/cabinet/order')
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
                                </div>

                            </div>
                            <div class="col-6 col-xxl-4">
                                <div class="d-doc__status">
                                    <div class="d-doc__title"><?= t("История заказа") ?>:</div>
                                    <ul class="status__time-line">
                                        <?php if ($order->payment_date) : ?>
                                            <li class="status__do">
                                                <div class="status__date-time mb-5"><b><?= date("d.m.Y", strtotime($order->payment_date)) ?></b> <?= date("H:i", strtotime($order->payment_date)) ?></div>
                                                <div class="status__text"><?= t("Платёж принят") ?></div>
                                            </li>
                                        <?php endif ?>
                                        <li>
                                            <div class="status__date-time mb-5"><b><?= date("d.m.Y", strtotime($order->created_at)) ?></b> <?= date("H:i", strtotime($order->created_at)) ?></div>
                                            <div class="status__text"><?= t("Заказ принят") ?></div>
                                        </li>
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