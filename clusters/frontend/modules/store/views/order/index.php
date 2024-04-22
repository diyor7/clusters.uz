<?php

use common\models\Address;
use common\models\Company;
use common\models\Order;
use common\models\User;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\MaskedInput;

$this->title = t("Оформление заказа");

$this->params['breadcrumbs'][] = $this->title;

$type = $user ? $user->companyType : Company::TYPE_PHYSICAL;

$deposit_percentage = isset(Yii::$app->params['deposit_percentage']) ? Yii::$app->params['deposit_percentage'] : 3;
$commission_percentage = isset(Yii::$app->params['commission_percentage']) ? Yii::$app->params['commission_percentage'] : 0.15;
?>

<main>
    <div class="page-head py-xl-30 wow fadeInUp">
        <div class="container">
            <h1 class="page-title mb-0"><?= $this->title ?></h1>
        </div>
    </div>

    <div class="container bg-white">
        <div class="checkout row pb-80 pt-10">
            <div class="col-lg-2 col-md-4 position-relative">
                <div class="disable-stepping"></div>
                <div class="nav flex-column nav-pills checkout__tabs text-right" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link mb-75 <?= Yii::$app->user->isGuest ? 'active' : 'form-filled' ?>" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">
                        <div class="row">
                            <div class="col"><b class="d-block font-family-monsterrat"><?= t("Авторизация") ?></b><span class="gray-text fs-15 font-family-roboto"><?= t("Первый шаг") ?></span></div>
                            <div class="col-2 p-0">
                                <div class="btn btn-secondary rounded-pill p-5"><img src="/img/user-white.svg"></div>
                            </div>
                        </div>
                    </a>
                    <a class="nav-link mb-75 <?= !Yii::$app->user->isGuest ? 'active' : '' ?>" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="true">
                        <div class="row">
                            <div class="col"><b class="d-block font-family-monsterrat"><?= t("Доставка") ?></b><span class="gray-text fs-15 font-family-roboto"><?= t("Второй шаг") ?></span></div>
                            <div class="col-2 p-0">
                                <div class="btn btn-secondary rounded-pill p-5"><img src="/img/delivery-white.svg"></div>
                            </div>
                        </div>
                    </a>
                    <a class="nav-link mb-75" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="true">
                        <div class="row">
                            <div class="col"><b class="d-block font-family-monsterrat"><?= t("Тип оплаты") ?></b><span class="gray-text fs-15 font-family-roboto"><?= t("Третий шаг") ?></span></div>
                            <div class="col-2 p-0">
                                <div class="btn btn-secondary rounded-pill p-5"><img src="/img/card-white.svg"></div>
                            </div>
                        </div>
                    </a>
                    <a class="nav-link" id="v-pills-4-tab" data-toggle="pill" href="#v-pills-4" role="tab" aria-controls="v-pills-4" aria-selected="true">
                        <div class="row">
                            <div class="col"><b class="d-block font-family-monsterrat"><?= t("Завершение") ?></b><span class="gray-text fs-15 font-family-roboto"><?= t("Последный шаг") ?></span></div>
                            <div class="col-2 p-0">
                                <div class="btn btn-secondary rounded-pill p-5"><img src="/img/check.svg"></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-10 col-md-8">
                <?php if (Yii::$app->user->isGuest) : ?>
                    <div class="tab-content h-100 position-relative pb-60" id="v-pills-tabContent">
                        <div class="tab-pane fade show active product-single-tabs" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-1-tab"><span class="font-family-roboto"><?= t("Первый шаг") ?></span>

                            <h3 class="gray-text-dark font-weight-bold fs-22"><?= t("Авторизация") ?></h3>

                            <div class="tab-content py-40" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pill-2" role="tabpanel" aria-labelledby="pill-2-tab">
                                    <div class="form">
                                        <div class="form-group row">
                                            <div class="px-15 d-inline-block col-10 align-middle col-md-3">
                                                <div class="dropdown">
                                                    <a class="btn btn-outline dropdown-toggle w-100 py-15 px-20 text-left" type="button" id="select-ecp" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <?= t("Выберите") ?>
                                                    </a>
                                                    <div class="dropdown-menu p-15" aria-labelledby="select-ecp" style="will-change: transform;" id="ecp-keys">

                                                    </div>
                                                </div>
                                                <button class="btn btn-success py-10 px-45 w-100 mt-20" id="login-btn" type="button">
                                                    <?= t("Следующий шаг") ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-center mt-50" id="message"></p>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php else : ?>
                    <?php $form = \yii\bootstrap\ActiveForm::begin([
                        'method' => 'POST',
                        'options' => [
                            'class' => 'h-100'
                        ]
                    ]) ?>
                    <div class="tab-content h-100 position-relative pb-60" id="v-pills-tabContent">
                        <div class="tab-pane fade show active pb-30" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-2-tab">
                            <span class="font-family-roboto"><?= t("Второй шаг") ?></span>
                            <h3 class="gray-text-dark font-weight-bold fs-22"><?= t("Доставка") ?></h3>
                            <p class="font-weight-bold fs-17 gray-text-dark pt-30 mb-20"><?= t("Получатель") ?></p>
                            <div class="row font-family-roboto">
                                <div class="form-group col-4">
                                    <?= $form->field($order, 'receiver_fio')->input('text', [
                                        'placeholder' => $order->getAttributeLabel('receiver_fio'),
                                        'class' => 'form-control px-20 py-15 w-100 mb-5'
                                    ])->label(false) ?>
                                    <span class="gray-text-darker fs-14 d-inline-block">
                                        <?= t("При получении доставки могут потребоваться фамилия, имя и отчество") ?>
                                    </span>
                                </div>
                                <div class="form-group col-4">
                                    <?= $form->field($order, 'receiver_phone')->widget(MaskedInput::className(), [
                                        'mask' => '\+\9\9\8999999999',
                                        'options' => [
                                            'placeholder' => $order->getAttributeLabel('receiver_phone'),
                                            'class' => 'form-control px-20 py-15 w-100 mb-5'
                                        ]
                                    ])->label(false) ?>
                                    <span class="gray-text-darker fs-14 d-inline-block">
                                        <?= t("Телефонный номер используется для уведомления об изменении статуса заказа") ?>
                                    </span>
                                </div>
                            </div>

                            <p class="font-weight-bold fs-17 gray-text-dark pt-30 mb-20"><?= t("Выберите тип доставки") ?></p>
                            <div class="selectable-blocks d-flex row">
                                <div class="form_radio_btn col-4">
                                    <input id="radio-11" type="radio" name="Order[delivery_address]" value="<?= Order::DELIVERY_TYPE_FREE_SHIPPING ?>" checked="">
                                    <label class="d-inline-block px-15 p-20 mr-20 font-family-roboto w-100" for="radio-11">
                                        <h4 class="fs-16 gray-text-dark mb-10 pb-0 font-family-monsterrat"><?= Order::getDeliveryTypes()[Order::DELIVERY_TYPE_FREE_SHIPPING] ?></h4>
                                        <p class="fs-16 gray-text-dark mb-0"><?= t("Доставка по городу Ташкенте бесплатно") ?></p>
                                        <p class="fs-16 gray-text-dark mb-0"> <b><?= t("Время доставки") ?>:</b> 3-7 <?= t("день") ?></p>
                                        <!-- <p class="fs-16 gray-text-dark mb-0"> <b><?= t("Условия доставки") ?>:</b> Изоҳи</p> -->
                                    </label>
                                </div>
                                <div class="form_radio_btn col-4">
                                    <input id="radio-12" type="radio" name="Order[delivery_address]" value="<?= Order::DELIVERY_TYPE_PICKUP_YOURSELF ?>">
                                    <label class="d-inline-block px-15 p-20 mr-20 font-family-roboto w-100" for="radio-12">
                                        <h4 class="fs-16 gray-text-dark mb-10 pb-0 font-family-monsterrat"><?= Order::getDeliveryTypes()[Order::DELIVERY_TYPE_PICKUP_YOURSELF] ?></h4>
                                        <p class="fs-16 gray-text-dark mb-0"><?= t("Вы можете забрать его сами, когда вам будет удобно") ?></p>
                                    </label>
                                </div>

                            </div>
                            <p class="font-weight-bold fs-17 gray-text-dark pt-30 mb-20"><?= t("Выберите адрес") ?></p>
                            <div class="selectable-blocks d-flex row addresses">
                                <?php foreach (Address::findAll(['user_id' => Yii::$app->user->id]) as $index => $address) : ?>
                                    <div class="form_radio_btn col-4 mb-20">
                                        <input id="radio-<?= $address->id ?>" type="radio" name="Order[address_id]" value="<?= $address->id ?>" <?= $index == 0 ? 'checked' : '' ?>>
                                        <label class="d-inline-block px-15 p-20 mr-20 font-family-roboto w-100" for="radio-<?= $address->id ?>">
                                            <h4 class="fs-16 gray-text-dark mb-10 pb-0 font-family-monsterrat"><?= $address->name ?></h4>
                                            <span class="font-family-roboto fs-14 gray-text-darker"><?= t("Адрес") ?></span>
                                            <p class="fs-16 gray-text-dark mb-0"><?= $address->text ?></p>
                                        </label>
                                    </div>
                                <?php endforeach ?>

                                <div class="d-flex col-4 mb-20 add-address-div">
                                    <a class="big-add-btn pl-lg-75 pl-sm-40 pr-40 gray-text-darker add-address" href="#!" data-toggle="modal" data-target="#address-modal"><?= t("Добавить новый адрес") ?></a>
                                </div>
                            </div>

                            <div class="form-group mb-10 position-absolute fixed-bottom mt-20">
                                <button type="button" class="btn btn-secondary rounded-pill px-30 disabled btn-second-step"><?= t("Следующий шаг") ?></button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-3-tab">
                            <span class="font-family-roboto"><?= t("Третий шаг") ?></span>
                            <h3 class="gray-text-dark font-weight-bold fs-22"><?= t("Оплата") ?></h3>
                            <?php if ($type == Company::TYPE_BUDGET || $type == Company::TYPE_COPERATE || $type == Company::TYPE_PRIVATE) : ?>
                                <p class="fs-17 gray-text-darker pt-30 mb-4 font-family-roboto">
                                    <?= t("Общая начальная сумма") ?>: <b class="fs-18 font-family-monsterrat ml-15 font-weight-bold"><?= $cart_data['total_sum_formatted'] ?><?= t("сум") ?></b>
                                </p>
                                <p class="fs-17 gray-text-darker pt-5 mb-4 font-family-roboto">
                                    <?= t("Сумма залога") ?>: <span class="fs-14 font-family-monsterrat ml-15"><?= showPrice($cart_data['deposit_sum']) ?><?= t("сум") ?></span>
                                </p>
                                <p class="fs-17 gray-text-darker pt-5 mb-4 font-family-roboto">
                                    <?= t("Комиссионный сбор") ?>: <span class="fs-14 font-family-monsterrat ml-15"><?= showPrice($cart_data['commission_sum']) ?><?= t("сум") ?></span>
                                </p>
                                <p class="fs-17 gray-text-darker pt-5 mb-20 font-family-roboto">
                                    <?= t("Общая блокированная сумма") ?>: <b class="fs-16 font-family-monsterrat ml-15 font-weight-bold"><?= showPrice($cart_data['total_block_sum']) ?><?= t("сум") ?></b>
                                </p>
                            <?php else : ?>
                                <p class="fs-17 gray-text-darker pt-30 mb-20 font-family-roboto">
                                    <?= t("Сумма оплаты") ?>: <b class="fs-18 font-family-monsterrat ml-15 font-weight-bold"><?= showPrice($order->total_sum) ?> <?= t("сум") ?></b>
                                </p>
                            <?php endif ?>
                            <div class="d-none">
                                <p class="font-weight-bold fs-17 gray-text-dark pt-30 mb-20"><?= t("Выберите тип оплаты") ?></p>
                                <div class="form-group row">
                                    <div class="px-15 d-inline-block col-10 align-middle custom-dropdown-tabs-select">
                                        <div class="custom-select  p-0 text-left font-family-roboto gray-text-darker" style="width:386px;">
                                            <?= $form->field($order, 'payment_type')->dropDownList(Order::getPaymentTypes(), [])->label(false) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="custom-dropdown-tabs">
                                    <div class="from_balance has-error custom-dropdown-tab mb-50" data-tab="<?= Order::PAYMENT_TYPE_BALANCE ?>" style="display: block;">
                                        <?php if ($user->availableBalance < $cart_data['total_block_sum']) : ?>
                                            <p class="pl-25 my-20 error-block font-family-roboto"><?= t("Недостаточно средств на вашем балансе в системе") ?></p>
                                            <a href="<?= toRoute('/cabinet/balance') ?>" class="btn rounded-pill text-white fs-15 px-25"><?= t("Пополнить баланс") ?></a>
                                            <span class="gray-text-darker font-family-roboto ml-25"><?= t("Недостаточное средство") ?>: <?= showPrice($cart_data['total_block_sum'] - $user->availableBalance) ?> <?= t("сум") ?></span>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>

                            <?php if ($user->availableBalance >= $cart_data['total_block_sum']) : ?>
                                <?= $form->field($order, 'agreement', ['template' => '
                        <div class="form-check  confirmation w-100 mt-60 pl-0">
                            {input}
                            <label class="form-check-label ml-25 d-inline-block col-lg-8 fs-14 gray-text-darker font-family-monsterrat " for="order-agreement">' .
                                    t('Нажимая кнопку «Оформить заказ», я соглашаюсь с {link}', [
                                        'link' => '<a class="secondary-text" href="' . toRoute('/offerta') . '">' . t('согласованным<br>договором оферты') . '</a>'
                                    ])
                                    . '</label>
                            {error}
                        </div>
                    '])->input('checkbox', [
                                    'class' => 'form-check-input ml-5'
                                ])->label(false) ?>
                                <div class="form-group mb-10 mt-20">
                                    <a class="btn-link px-30 btn-prev underline-text fs-15"><?= t("Назад") ?></a>
                                    <?php $user = User::findOne(Yii::$app->user->id); ?>
                                    <button class="btn btn-secondary rounded-pill px-30 " data-sign="true" data-tin="<?= $user->company->tin ?>" data-confirm="<?= t("Вы точно хотите принять? Мы снимем с вашего баланса {currency} сум, {deposit_percentage}% в виде залога от стартовой суммы и {commission_percentage}% в виде комиссии от введенной суммы.", [
                                                                                                                                                                    'deposit_percentage' => $deposit_percentage,
                                                                                                                                                                    'currency' => showPrice($cart_data['total_block_sum']),
                                                                                                                                                                    'commission_percentage' => $commission_percentage
                                                                                                                                                                ]) ?>">
                                        <?= t('Оформить заказ') ?>
                                    </button>
                                </div>
                            <?php endif ?>

                        </div>
                        <div class="tab-pane fade" id="v-pills-4" role="tabpanel" aria-labelledby="v-pills-4-tab"></div>
                    </div>
                    <?php \yii\bootstrap\ActiveForm::end(); ?>

                <?php endif ?>
            </div>
        </div>

    </div>
</main>

<div class="modal show fade  pr-0" id="address-modal" tabindex="-1" role="dialog" aria-labelledby="address-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content animate-bottom px-40 pt-50 pb-50 d-inline-block">
            <h2 class="primary-text font-weight-bold fs-20 mb-20">
                <?= t("Добавление нового адреса") ?>
                <a class="float-right" href="#!" data-dismiss="modal" aria-label="Close"><i class="icon_close"></i></a>
            </h2>

            <div class="modal-body p-0">
                <?php $form =  \yii\bootstrap\ActiveForm::begin([
                    'action' => toRoute("/test"),
                    'method' => 'POST',
                    'options' => [
                        'class' => 'form'
                    ],
                    'id' => "address-form"
                ]);
                $model = new \common\models\Address([
                    'user_id' => \Yii::$app->user->id,
                    'created_at' => date("Y-m-d H:i:s"),
                    'latitude' => 41.311081,
                    'longitude' => 69.240562
                ]);
                ?>
                <div class="form-group mb-25">
                    <?= $form->field($model, 'name')->input('text', [
                        'class' => 'form-control py-20 px-30'
                    ]) ?>
                </div>
                <div id="map"></div>
                <?= $form->field($model, 'latitude')->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'longitude')->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'text')->hiddenInput()->label(false) ?>
                <div class="form-group mb-0 mt-30">
                    <?= Html::submitButton($model->isNewRecord ? t('Добавить') : t("Редактировать"), ['class' => 'btn btn-secondary rounded-pill py-5  px-45 h-auto']); ?>
                </div>
                <?php \yii\bootstrap\ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<script src="https://api-maps.yandex.ru/2.1/?lang=<?= Yii::$app->language == 'uz' ? 'uz_UZ' : (Yii::$app->language == 'ru' ? 'ru_RU' : "en_US") ?>&amp;apikey=5cf94247-5d46-472c-a903-a1bbd9edd976" type="text/javascript"></script>

<style>
    #map {
        width: 100%;
        height: 500px;
        padding: 0;
        margin: 0;
    }
</style>
<?php
$this->registerJs('

    var receiver_fio = false;
    var receiver_phone = false;

    if (' . (($order->receiver_fio && $order->receiver_phone) ? 'true' : 'false') . '){
        $("#w0").yiiActiveForm("validateAttribute", "order-receiver_fio");
        $("#w0").yiiActiveForm("validateAttribute", "order-receiver_phone");
    }
    
    $("#order-receiver_fio, #order-receiver_phone").on("input", function(e){
        $("#w0").yiiActiveForm("validateAttribute", e.target.id);
    });

    $(".btn-second-step").click(function (){
        $("#w0").yiiActiveForm("validateAttribute", "order-receiver_fio");
        $("#w0").yiiActiveForm("validateAttribute", "order-receiver_phone");
    });

    $("#w0").on("afterValidateAttribute", function (event, attribute, messages) {
        if (attribute.name == "receiver_fio") {
            receiver_fio = messages.length == 0;
        }

        if (attribute.name == "receiver_phone") {
            receiver_phone = messages.length == 0;
        }

        if (receiver_phone && receiver_fio) {
            $(".btn-second-step").removeClass("disabled").addClass("btn-next");
        } else {
            $(".btn-second-step").addClass("disabled").removeClass("btn-next");
        }
    });

    var inited = false;

    $("#address-modal").on("shown.bs.modal", function (){
        if (!inited){
            inited = true;

            ymaps.ready(function() {
                var myMap = new ymaps.Map("map", {
                    center: [' . ($model->latitude ? $model->latitude : 41.311081) . ', ' . ($model->longitude ? $model->longitude : 69.240562) . '],
                    zoom: 12
                }, {
                    searchControlProvider: "yandex#search"
                });
        
                var placemark = new ymaps.Placemark([' . ($model->latitude ? $model->latitude : 41.311081) . ', ' . ($model->longitude ? $model->longitude : 69.240562) . '], {}, {
                    iconColor: "#ff0000",
                    draggable: true
                });
        
                placemark.events.add("dragend", function(events) {
        
                    var latitude = placemark.geometry.getCoordinates()[0];
                    var longitude = placemark.geometry.getCoordinates()[1];
        
                    $("#address-latitude").val(latitude);
                    $("#address-longitude").val(longitude);
        
                    var url = "https://nominatim.openstreetmap.org/reverse?lat=" + latitude + "&lon=" + longitude + "&format=json&accept-language=" + $("html").attr("lang");
        
                    $.ajax({
                        type: "GET",
                        url: url,
                        success: function(data) {
                            if (data && data.display_name) {
                                $("#address-text").val(data.display_name);
                            }
                        }
                    });
                });
        
                myMap.events.add("click", function(e) {
                    // Получение координат щелчка
                    var coords = e.get("coords");
                    placemark.geometry.setCoordinates(coords);
        
                    var latitude = coords[0];
                    var longitude = coords[1];
        
                    $("#address-latitude").val(latitude);
                    $("#address-longitude").val(longitude);
                });
        
                myMap.geoObjects.add(placemark);
            });
        }
    });

    $("#address-form").on("beforeSubmit", function (e){
        e.preventDefault();

        var _this = this;

        var arr = $(this).serializeArray();

        var data = {};

        for (var i = 0; i < arr.length; i++){
            data[arr[i].name] = arr[i].value;
        }

        $.ajax({
            url: "' . toRoute('/user/address/create-ajax') . '",
            method: "POST",
            data: data
        }).done(function (res){
            if (res.status == "success"){
                $(".addresses input").removeAttr("checked");
                $("<div class=\"form_radio_btn col-4 mb-20\"> <input id=\"radio-" + res.id + "\" type=\"radio\" name=\"Order[address_id]\" value=\"" + res.id + "\" checked><label class=\"d-inline-block px-15 p-20 mr-20 font-family-roboto w-100\" for=\"radio-" + res.id + "\"> <h4 class=\"fs-16 gray-text-dark mb-10 pb-0 font-family-monsterrat\">" + res.name + "</h4> <span class=\"font-family-roboto fs-14 gray-text-darker\">" + "' . t("Адрес") . '" +"</span> <p class=\"fs-16 gray-text-dark mb-0\">" + res.text + "</p> </label> </div>").insertBefore(".add-address-div");
                $("#address-modal").modal("hide");
                toastr.success("' . t("Адрес успешно добавлен") . '");
                $("#address-form").get(0).reset();
            } else {
                toastr.error("' . t("Адрес не добавлен. Повторите попытку") . '");
            }
        });

        return false;
    });
', View::POS_READY);
?>