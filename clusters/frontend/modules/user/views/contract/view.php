<?php

use common\models\Contract;

/**
 * @var $model common\models\Contract
 */

$this->title = t("Договор №{number} от {date}", ['number' => $model->id, 'date' => date("d.m.Y", strtotime($model->created_at))]);

$this->params['breadcrumbs'][] = array(
    'label' => t("Личный кабинет"),
    'url' => toRoute('/user')
);

$this->params['breadcrumbs'][] = array(
    'label' => t("Договоры"),
    'url' => toRoute('/user/contract')
);
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render("../layouts/_nav", [
    'breadcrumb_title' => t("Договоры"),
    'breadcrumb_url' => toRoute('/user/contract'),
]) ?>

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
                                    <div class="col">
                                        <div class="d-doc__total">
                                            <div class="d-doc__title"><?= t("Общая сумма") ?>:</div>
                                            <div class="d-doc__text d-doc-text--price fs-36 font-weight-bold">‭<?= showPrice($model->price) ?> <?= t("сум") ?></div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-doc__pdf-link"><a href="<?= toRoute("/" . Yii::$app->controller->module->id . '/contract/pdf/' . $model->id) ?>" class="btn btn-link rounded-pill fs-15"><i class="icon-file-text mr-5 fs-17"></i> <?= t("Экспорт в PDF") ?></a></div>
                                    </div>
                                </div>

                                <div class="d-doc__brand">
                                    <div class="d-doc__title mb-5"> <?= t("Информация о поставщике") ?>:</div>

                                    <div class="brand__details mt-30 fs-15">
                                        <div class="row">
                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Наименование") ?>:</div>
                                                    <div class="d-doc__text"><?= $model->producer->name ?></div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("ИНН поставщика") ?>:</div>
                                                    <div class="d-doc__text"><?= $model->producer->tin ?></div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Юридический адрес") ?>:</div>
                                                    <div class="d-doc__text"><?= $model->producer->address ?></div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Контактный телефон") ?>:</div>
                                                    <div class="d-doc__text"><a href="tel:<?= $model->producer->phone ?>" target="_blank" class="link--black"><?= $model->producer->phone ?></a></div>
                                                </div>
                                            </div>

                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Почта") ?>:</div>
                                                    <div class="d-doc__text"><?= $model->producer->email ? $model->producer->email : t("(не указано)") ?></div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6">
                                                <div class="brand__detail mb-20 pl-20">
                                                    <div class="d-doc__title fw-semi-bold mb-5"><?= t("Веб сайт") ?>:</div>
                                                    <div class="d-doc__text"><?= $model->producer->site ? $model->producer->site : t("(не указано)") ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-6 col-xxl-4">
                                <div class="d-doc__status">
                                    <div class="d-doc__title"><?= t("История договора") ?>:</div>

                                    <ul class="status__time-line">

                                        <li>
                                            <div class="status__date-time mb-5"><b><?= date("d.m.Y", strtotime($model->created_at)) ?> </b> <?= date("H:i", strtotime($model->created_at)) ?></div>
                                            <div class="status__text"><?= t("договор оформлён") ?></div>
                                        </li>

                                        <?php if ($model->customer_sign_date) : ?>
                                            <li>
                                                <div class="status__date-time mb-5"><b><?= date("d.m.Y", strtotime($model->customer_sign_date)) ?> </b> <?= date("H:i", strtotime($model->customer_sign_date)) ?></div>
                                                <div class="status__text"><?= t("заказчик подписал договор") ?></div>
                                            </li>
                                        <?php endif ?>

                                        <?php if ($model->producer_sign_date) : ?>
                                            <li>
                                                <div class="status__date-time mb-5"><b><?= date("d.m.Y", strtotime($model->producer_sign_date)) ?> </b> <?= date("H:i", strtotime($model->producer_sign_date)) ?></div>
                                                <div class="status__text"><?= t("поставщик подписал договор") ?></div>
                                            </li>
                                        <?php endif ?>

                                        <?php if ($model->customer_pay_date) : ?>
                                            <li>
                                                <div class="status__date-time mb-5"><b><?= date("d.m.Y", strtotime($model->customer_pay_date)) ?> </b> <?= date("H:i", strtotime($model->customer_pay_date)) ?></div>
                                                <div class="status__text"><?= t("заказчик оплатил в РКП по договору") ?></div>
                                            </li>
                                        <?php endif ?>

                                        <?php if ($model->customer_mark_delivered_date) : ?>
                                            <li>
                                                <div class="status__date-time mb-5"><b><?= date("d.m.Y", strtotime($model->customer_mark_delivered_date)) ?> </b> <?= date("H:i", strtotime($model->customer_mark_delivered_date)) ?></div>
                                                <div class="status__text"><?= t("товары поставлены") ?></div>
                                            </li>
                                        <?php endif ?>

                                        <?php if ($model->customer_cancel_date) : ?>
                                            <li>
                                                <div class="status__date-time mb-5"><b><?= date("d.m.Y", strtotime($model->customer_cancel_date)) ?> </b> <?= date("H:i", strtotime($model->customer_cancel_date)) ?></div>
                                                <div class="status__text"><?= t("заказчик расторгнул договор") ?></div>
                                            </li>
                                        <?php endif ?>

                                        <?php if ($model->producer_cancel_date) : ?>
                                            <li>
                                                <div class="status__date-time mb-5"><b><?= date("d.m.Y", strtotime($model->producer_cancel_date)) ?> </b> <?= date("H:i", strtotime($model->producer_cancel_date)) ?></div>
                                                <div class="status__text"><?= t("поставщик расторгнул договор") ?></div>
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
                                    <?php if($model->order): ?>
                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th><?= t("Товар") ?></th>
                                                <th class="text-center"><?=t("Код ТН ВЭД")?></th>
                                                <th class="text-center"><?= t("Количество") ?></th>
                                                <th class="text-center"><?= t("Предложенная цена") ?></th>
                                                <th class="text-right"><?= t("Сумма") ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($model->order->orderLists as $index => $model_list) : ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= $model_list->product->title ?></td>
                                                    <td class="text-center"><?= $model_list->product->code ?></td>
                                                    <td class="text-center"><?= $model_list->quantity ?></td>
                                                    <td class="text-center"><?= showPrice($model->order->winner->price) ?> <?= t("сум") ?></td>
                                                    <td class="text-right"><?= showPrice($model_list->quantity * $model->order->winner->price) ?> <?= t("сум") ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    <?php elseif($model->auction):?>

                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th><?= t("Товар") ?></th>
                                                <th class="text-center"><?=t("№ ЛОТА")?></th>
                                                <th class="text-center"><?= t("Количество товара") ?></th>
                                                <th class="text-center"><?= t("Предложенная цена") ?></th>
                                                <th class="text-right"><?= t("Сумма") ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($model->auction->auctionCategories as $index => $auctionCategory) : ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= $auctionCategory->category->title ?></td>
                                                    <td class="text-center"><?= $model->auction_id ?></td>
                                                    <td class="text-center"><?= showQuantity($auctionCategory->quantity) ?> <?= $auctionCategory->unit->title ?></td>
                                                    <td class="text-center"><?= showPrice($auctionCategory->price * ($model->auction->currentPrice / $model->auction->total_sum)) ?> <?= t("сум") ?></td>
                                                    <td class="text-right"><?= showPrice($model->auction->currentPrice) ?> <?= t("сум") ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>