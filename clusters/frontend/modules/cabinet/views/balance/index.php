<?php

use common\models\CompanyTransaction;

$this->title = t("Баланс");

$this->params['breadcrumbs'][] = array(
    'label' => t("Личный кабинет"),
    'url' => toRoute('/cabinet')
);
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render("../layouts/_nav", [
    'btn_title' => $company_balance->show_balance === 1 ? t("Скрыть баланс") : t("Показать баланс"),
    'btn_url' => toRoute('/' . Yii::$app->controller->module->id . '/balance/visibility')
]) ?>

<div class="new-bg-different py-30">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?= $this->render("../layouts/_menu") ?>
            </div>
            <div class="col-md-9">
                <div class="d-balance-info mb-30">
                    <div class="row">
                        <div class="col-3">
                            <div class="d-balance-info__item widget widget--primary rounded px-20 py-15 wow fadeInDown">
                                <div class="widget__title text-uppercase fs-12 text-white font-weight-bold mb-10"><?= t("Баланс") ?></div>
                                <div class="widget__sum fs-16 font-weight-bold text-white"><?= $company_balance->show_balance === 1 ? showPrice($company_balance->balance) : "*** *** *** ***" ?> <small class="fs-12 font-weight-bold"><?= t("сум") ?></small></div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="d-balance-info__item widget widget--secondary rounded px-20 py-15 wow fadeInDown">
                                <div class="widget__title text-uppercase fs-12 text-white font-weight-bold mb-10"><?= t("Свободный остаток") ?></div>
                                <div class="widget__sum fs-16 font-weight-bold text-white"><?= $company_balance->show_balance === 1 ? showPrice($company_balance->available) : "*** *** *** ***" ?> <small class="fs-12 font-weight-bold"><?= t("сум") ?></small></div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="d-balance-info__item widget widget--danger rounded px-20 py-15 wow fadeInDown">
                                <div class="widget__title text-uppercase fs-12 text-white font-weight-bold mb-10"><?= t("Заблокирован (залог)") ?></div>
                                <div class="widget__sum fs-16 font-weight-bold text-white"><?= $company_balance->show_balance === 1 ? showPrice($company_balance->blocked) : "*** *** *** ***" ?> <small class="fs-12 font-weight-bold"><?= t("сум") ?></small></div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="d-balance-info__item widget widget--dark rounded px-20 py-15 wow fadeInDown">
                                <div class="widget__title text-uppercase fs-12 text-white font-weight-bold mb-10"><?= t("Расходы / издержки") ?></div>
                                <div class="widget__sum fs-16 font-weight-bold text-white"><?= $company_balance->show_balance === 1 ? showPrice($company_balance->outplay) : "*** *** *** ***" ?> <small class="fs-12 font-weight-bold"><?= t("сум") ?></small></div>
                            </div>
                        </div>
                        <!-- <div class="col-3">
                            <div class="d-balance-info__item widget widget--primary rounded px-20 py-15 wow fadeInDown">
                                <div class="widget__title text-uppercase fs-12 text-white font-weight-bold mb-10"><?= t("Ожидание") ?></div>
                                <div class="widget__sum fs-16 font-weight-bold text-white"><?= $company_balance->show_balance === 1 ? showPrice($company_balance->outgoing) : "*** *** *** ***" ?> <small class="fs-12 font-weight-bold"><?= t("сум") ?></small></div>
                            </div>
                        </div> -->
                    </div>
                </div>
                <?php if ($company && $company_balance) : ?>

                    <?php $transactions = CompanyTransaction::find()->where(['company_id' => $company->id])->orderBy('created_at desc, id desc')->all(); ?>

                    <div class="i-list mb-30 mt-10">
                        <div class="i-list__head px-20 mb-20">
                            <div class="row no-gutters">
                                <div class="col-2">
                                    <div class="i-list__sortable"><?= t('Номер транзакции и дата добавления') ?></div>
                                </div>
                                <div class="col-2 col-xxl-1 text-center">
                                    <div class="i-list__sortable"><?= t("Заказ") ?></div>
                                </div>
                                <div class="col-2 text-center">
                                    <div class="i-list__sortable"><?= t("Договор") ?></div>
                                </div>
                                <div class="col-2 text-left">
                                    <div class="i-list__sortable"><?= t("Тип транзакция") ?></div>
                                </div>
                                <div class="col text-right">
                                    <div class="i-list__sortable"><?= t("Описание") ?></div>
                                </div>
                                <div class="col-2 text-right">
                                    <div class="i-list__sortable"><?= t("Сумма") ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="i-list__body">
                            <div class="i-list__items">
                                <?php if (count($transactions) == 0) : ?>
                                    <div class="item shadow bg-white rounded mb-10 py-15 px-20 fs-15 wow fadeInUp">
                                        <?= t("Ничего не найдено") ?>
                                    </div>
                                <?php endif ?>

                                <?php foreach ($transactions as $transaction) : ?>
                                    <div class="item shadow bg-white rounded mb-10 py-15 px-20 fs-15 wow fadeInUp">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-2"><b class="mr-5">№<?= $transaction->id ?></b> <span><?= date("d.m.Y  H:i", strtotime($transaction->created_at)) ?></span></div>
                                            <div class="col-2 col-xxl-1 text-center fw-semi-bold">
                                                <?php if ($transaction->order) : ?>
                                                    <a class="text-767676" href="<?= toRoute('/' . Yii::$app->controller->module->id . '/order/' . $transaction->order_id) ?>">
                                                        <?= t("Заказ №{number} от {date}", ['number' => $transaction->order_id, 'date' => date("d.m.Y", strtotime($transaction->order->created_at))]) ?>
                                                    </a>
                                                <?php endif ?>
                                            </div>
                                            <div class="col-2 text-center">
                                                <?php if ($transaction->contract) : ?>
                                                    <a class="text-767676" href="<?= toRoute('/' . Yii::$app->controller->module->id . '/contract/' . $transaction->contract_id) ?>">
                                                        <?= t("Договор №{number} от {date}", ['number' => $transaction->contract_id, 'date' => date("d.m.Y", strtotime($transaction->contract->created_at))]) ?>
                                                    </a>
                                                <?php endif ?>
                                            </div>
                                            <div class="col-2 text-left"><?= $transaction->typeName ?></div>
                                            <div class="col text-right">
                                                <div class="item__price"><?= $transaction->description ?></div>
                                            </div>
                                            <div class="col-2 text-right">
                                                <div class="item__price"><?= $transaction->typeNamePlusMinus .  showPrice($transaction->currency) ?> <span><?= t("сум") ?></span></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<?php $this->registerJs('', \yii\web\View::POS_END); ?>