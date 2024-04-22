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

<div class="">
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
            <a href="<?= toRoute('/auction') ?>"><?=t("Аукцион")?></a>
            <span></span>
            <p><?= $this->title ?></p>
        </div>
    </div>
</div>

<div class="new-bg-different pb-30">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="  h-100 py-60">
                    <h2 class="new-title-5 border-0">№  <?= t("ЛОТА") .': ' . $model->id ?></h2>
                    <h1 class="new-title-6"><?= $name ?></h1>

                    <div class="row">
                        <div class="col-lg-9">
                            <?php foreach ($model->auctionCategories as $index => $auctionCategory) : ?>
                                <div class="auction mt-25">
                                    <div class="content">
                                        <h4 class="new-title-5 border-0">№ <?= $index + 1 ?></h4>

                                        <h3 class="new-title-7"><?= $auctionCategory->category->title ?></h3>

                                        <p class="description">
                                            <?= $auctionCategory->description ?>
                                        </p>
                                    </div>
                                    <div class="footer">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <div class="label"><?=t("Количество товара")?></div>
                                                <div class="value">
                                                    <?= showQuantity($auctionCategory->quantity) ?> <?= $auctionCategory->unit->title ?>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="label"><?=t("Стартовая цена за единицу")?></div>
                                                <div class="value">
                                                    <?= showPrice($auctionCategory->price) ?> <?= t("сум") ?>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="label"><?=t("Текущая предложенная цена")?></div>
                                                <div class="value">
                                                    <?php if ($model->total_sum === $model->currentPrice) : ?>
                                                        <?= t("Пока не подана") ?>
                                                    <?php else : ?>
                                                        <?= showPrice($auctionCategory->price * ($model->currentPrice / $model->total_sum)) ?> <?= t("сум") ?>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="label"><?=t("Следующая цена")?></div>
                                                <div class="value">
                                                    <?= showPrice($auctionCategory->price * ($model->currentPrice / $model->total_sum - 0.02)) ?> <?= t("сум") ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>

                            <?php if (count($model->auctionConditions) > 0) : ?>
                                <div class="auction-conditions my-35">
                                    <div class="new-title-8"><?=t("Особые условия")?></div>
                                    <ul>
                                        <?php
                                            foreach ($model->auctionConditions as $auctionCondition) :
                                                $cat_name = $auctionCondition->texts;
                                                foreach (json_decode($auctionCondition->inputs) as $x){
                                                    if(is_array($x)){
                                                        $x = $x[0];
                                                    }
                                                    $cat_name = preg_replace("/:X/", $x, $cat_name, 1 );
                                                }

                                        ?>
                                            <li>
                                                <img src="/img/new-check.svg" alt="">
                                                <?= $cat_name ?>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            <?php endif ?>

                            <div class="auction-info my-40">
                                <div class="new-title-8"><?=t("Информация о лоте и заказчике")?></div>
                                <table class="w-100 my-20">
                                    <tr>
                                        <th><?=t("ИНН")?>:</th>
                                        <td><?= $model->company->tin ?></td>
                                    </tr>
                                    <tr>
                                        <th><?=t("Название организации")?>:</th>
                                        <td><?= $model->company->name ?></td>
                                    </tr>
                                    <tr>
                                        <th><?=t("Адрес заказчика")?>:</th>
                                        <td><?= $model->company->address ?></td>
                                    </tr>
                                    <tr>
                                        <th><?=t("Адрес доставки")?>:</th>
                                        <td><?= $model->address ?></td>
                                    </tr>
                                    <tr>
                                        <th><?=t("Телефон")?>:</th>
                                        <td><?= $model->company->phone ?></td>
                                    </tr>
                                    <tr>
                                        <th><?=t("Лицевой счет заказчика в казначействе")?>:</th>
                                        <td><?= $model->company->companyBankAccount->account ?></td>
                                    </tr>
                                    <tr>
                                        <th><?=t("Условия поставки")?>:</th>
                                        <td><?=t("Продавец осуществляет доставку")?></td>
                                    </tr>
                                    <tr>
                                        <th><?=t("Срок поставки (рабочих дней)")?>:</th>
                                        <td><?= $model->delivery_period ?></td>
                                    </tr>
                                    <tr>
                                        <th><?=t("Срок оплаты")?>:</th>
                                        <td><?= $model->payment_period ?></td>
                                    </tr>
                                    <tr>
                                        <th><?=t("Залог (на следующую цену)")?>:</th>
                                        <td><?= showPrice($model->currentPrice * 0.1) ?> <?= t("сум") ?></td>
                                    </tr>
                                    <tr>
                                        <th><?=t("Сумма ком сбора (на следующую цену)")?>:</th>
                                        <td><?= showPrice($model->currentPrice * 0.01) ?> <?= t("сум") ?></td>
                                    </tr>
                                    <tr>
                                        <th><?=t("Дата начала")?>:</th>
                                        <td><?= date("d.m.Y", strtotime($model->created_at)) ?></td>
                                    </tr>
                                    <tr>
                                        <th><?=t("Дата окончания")?>:</th>
                                        <td><?= date("d.m.Y H:i:s", strtotime($model->auction_end)) ?></td>
                                    </tr>
                                    <tr>
                                        <th><?=t("Просмотры")?>:</th>
                                        <td><?= $model->views ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="auction-action mt-25">
                                <h2 id="demo">--:--:--:--</h2>
                                <p class="subtitle"><?=t("Срок окончания")?></p>
                                <input type="hidden" value="<?= date("M d, Y H:i:s", strtotime($model->auction_end)) ?>" id="end_time_value">

                                <div id="price_lot_box">

                                </div>

                                 <a href="#!" id="requester" class="action mt-20 w-100 text-center" data-toggle="modal" data-target="#requestModal"><?=t("Подать заявку")?></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="requestModal">
    <div class="modal-dialog request-modal modal-lg modal-dialog-centered">
        <div class="modal-body bg-white">
            <div class="text-right">
                <a class="cursor-pointer" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="/img/modal-close.svg" alt="">
                </a>
            </div>
            <h2> <?= t("Вы действительно хотите отправить заявку на лот № {m}", [
                'm' =>$model->id
            ]) ?> ?</h2>

            <table class="table w-100">
                <thead>
                    <tr>
                        <th>
                            <?= t("Товар") ?>
                        </th>
                        <th>
                            <?= $name ?>
                        </th>
                    </tr>
                </thead>
            </table>
            <p class="font-size-12 text-center">
                <?=t("Торги проводятся в электронной системе путем пошагового снижения стартовой цены. Размер шага торгов составляет {per} %",[
                        'per' => Yii::$app->params['percentage_of_each_step']
                ])?>
            </p>
            <?php
                $text = ( $model->nextPrice / $model->total_sum ) > Yii::$app->params['dumping_percentage'] ? t("Вы точно хотите принять? Общая сумма: {total_sum} сум. Мы снимем с вашего баланса {deposit_percentage}% в виде залога от стартовой суммы и {commission_percentage}% в виде комиссии от введенной суммы.", [
                    'deposit_percentage' => Yii::$app->params['deposit_percentage'],
                    'commission_percentage' => Yii::$app->params['commission_percentage'],
                    'total_sum' => $model->total_sum
                ]) : t("Вы точно хотите принять? Общая сумма: {total_sum} сум. Мы снимем с вашего баланса {deposit_percentage} сум в виде залога от стартовой суммы и {commission_percentage} сум в виде комиссии от введенной суммы.", [
                    'deposit_percentage' => $model->total_sum * Yii::$app->params['deposit_percentage'] / 100,
                    'commission_percentage' => $model->total_sum - $model->nextPrice,
                    'total_sum' => $model->total_sum
                ]);
                if($user):
            ?>
                <a href="<?= Yii::$app->user->isGuest || true ? toRoute(['/auction/offer/'. $model->id . '/' . $model->nextPrice]) : '#!' ?>"
                    class="btn btn-success mt-20 text-center float-right"
                    data-sign="true"
                    data-tin="<?= $user->company->tin ?>"
                    data-ajax="true"
                    data-confirm="<?= $text ?>"
                    > <?= t("Подать заявку") ?>
                </a>
            <?php else : ?>
                <a href="<?= toRoute(['/site/login/'])?>" class="btn btn-success mt-20 text-center float-right" > <?= t("Войти в систему") ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>


<script>
    var lang = document.getElementsByTagName('html')[0].getAttribute('lang');

    var end_value = document.getElementById('end_time_value').value;
    var countDownDate = new Date(end_value).getTime();

    var x = setInterval(function() {
        var now = new Date().getTime();

        var distance = countDownDate - now;

        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        if(hours < 10){
            hours = "0"+hours;
        }

        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        if(minutes < 10){
            minutes = "0"+minutes;
        }

        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        if(seconds < 10){
            seconds = "0"+seconds;
        }

        var kun_nomi = days > 0 ? (lang === 'ru' ? days + 'Д:' : days + 'D:') : '';

        document.getElementById("demo").innerHTML = kun_nomi + hours + ":" + minutes + ":" + seconds;
        //tugaganida.
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "00:00:00";
            document.getElementById('requester').setAttribute("disabled", true);
        }
    }, 1000);
</script>
<?php $this->registerJs('
    function loadPrice(){
        var list = $("#price_lot_box");
        list.load("' . toRoute(['get-prices', 'auctionRequests' => count($model->auctionRequests) + 0, 'total_sum' => $model->total_sum, 'currentPrice' => $model->currentPrice, 'nextPrice' => $model->nextPrice]) . '");
    }
    $( document ).ready(function() {
        loadPrice();
    });
    setInterval(function(){ loadPrice(); }, 15000);
', \yii\web\View::POS_END);