<?php

use common\models\Category;
use common\models\Condition;
use common\models\Region;
use common\models\Tn;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;

$this->title = $model->isNewRecord ? t("Размещение тендера") : t("Редактировать тендер");

$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render("../layouts/_menu") ?>

<div class="page-head py-30">
    <div class="container-fluid">
        <h1 class="page-title mb-0">
            <?= $this->title ?>
        </h1>
    </div>
</div>

<div class="container-fluid my-40">
    <div class="cabinet__content">
        <div class="row justify-content-md-center">
            <div class="col-md-8 col-xxl-6">
                <div class="shadow rounded bg-white p-20 fs-15">
                    <?php $form =  \yii\bootstrap\ActiveForm::begin([
                        'method' => 'POST',
                        'options' => [
                            'class' => 'form'
                        ],
                        'id' => "product-form"
                    ]) ?>
                    <div class="tab-content pt-15 mt-15 pb-15" id="pills-tabContent">
                        <div class="tab-pane font-family-roboto fade show active" id="pill-1" role="tabpanel" aria-labelledby="pill-1-tab">

                            <div class="form-group mb-25">
                                <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->where(['status' => Category::STATUS_ACTIVE])->all(), 'id', function ($m) {
                                    return $m->title;
                                }), [
                                    'class' => 'form-control px-30',
                                    'prompt' => t(" - Выберите - ")
                                ]) ?>
                            </div>

                            <div id="root">
                                <h5 class="text-center"><?=t("НАИМЕНОВАНИЕ ЗАКАЗА")?></h5>

                                <input type="text" class="form-control" placeholder="Поиск по продуктам" id="product-search">

                                <div id="products" class="my-25" style="height: 350px; overflow-y: scroll; padding: 10px; border: 3px solid #f8f8f8">
                                    <p class="text-center"><?= t("Продукты показываются по поиску") ?></p>
                                </div>

                                <div id="tns">
                                    <?php foreach ($tns as $tn) : ?>
                                        <?php $m = Tn::findOne($tn->tn_id);?>
                                        <?=$this->render("_tn-form", ['model' => $m, 'existModel' => $tn])?>
                                    <?php endforeach ?>
                                </div>
                                
                                <div class="form-group mb-25">
                                    <?= $form->field($model, 'condition_ids')->checkboxList(ArrayHelper::map(Condition::find()->all(), 'id', 'title'))->label("Особые условия") ?>
                                </div>
                                <div class="form-group mb-25">
                                    <?= $form->field($model, 'total_sum')->input('number', ['readonly' => true]) ?>
                                </div>
                                <div class="form-group mb-25">
                                    <?= $form->field($model, 'delivery_period')->input('number') ?>
                                </div>
                                <div class="form-group mb-25">
                                    <?= $form->field($model, 'payment_period')->input('number', ['readonly' => true]) ?>
                                </div>
                                <h5 class="text-center">Адрес доставки</h5>
                                <div class="form-group mb-25">
                                    <?= $form->field($model, 'receiver_email')->input('email') ?>
                                </div>
                                <div class="form-group mb-25">
                                    <?= $form->field($model, 'receiver_phone')->widget(MaskedInput::className(), [
                                        'mask' => '\+\9\9\8999999999',
                                        'options' => [
                                            'class' => 'form-control',
                                        ]
                                    ]) ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->field($model, 'region_id')->dropDownList(Region::getTree(), [
                                        'class' => 'form-control px-30',
                                    ]) ?>
                                </div>
                                <div class="form-group mb-25">
                                    <?= $form->field($model, 'zip_code')->input('text') ?>
                                </div>
                                <div class="form-group mb-25">
                                    <?= $form->field($model, 'address')->input('text') ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <?= Html::submitButton($model->isNewRecord ? t('Добавить') : t("Редактировать"), ['class' => 'btn btn-secondary rounded-pill py-5  px-45 h-auto']); ?>
                    </div>
                    <?php \yii\bootstrap\ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$search_url = toRoute('/auction/default/search');
$tn_form_url = toRoute('/auction/default/tn-form');

$JS = <<< JS
    var timeout;
    $("#product-search").on('input', function (){
        if (timeout) clearTimeout(timeout);

        var q = this.value;
        var category_id = $("#auction-category_id").val();

        timeout = setTimeout(() => {
            $.ajax({
                url: "$search_url" + "?q=" + q + "&category_id=" + category_id,
                method: "GET"
            }).done(function (res) {
                $("#products").html(res);
            });
        }, 1000);
    });

    $(document).on("click", ".select-tn", function (){
        var tn_id = $(this).data("tn");

        $.ajax({
            url: "$tn_form_url?tn_id=" + tn_id,
            method: "GET"
        }).done(function (res) {
            $("#tns").append(res);
            correctNumber();
        });
    });

    $(document).on("change", ".calc-qp", function (){
        var vals = [];
        $(this).closest(".panel").find(".calc-qp").each((i, el) => {
            if (el.value) {
                vals.push(el.value);
            }
        });

        if (vals.length == 2) {
            var sum = parseFloat(vals[0] * vals[1]);

            $(this).closest(".panel").find(".calc-r").val(sum).trigger("change");
        }
    });

    $(document).on("change", ".calc-r", function (){
        var sums = [];
        $("#tns").find(".calc-r").each((i, el) => {
            console.log(el);
            if (el.value) {
                sums.push(el.value);
            }
        });

        if (sums.length == $("#tns").find(".calc-r").length) {
            var sum = 0;

            for (var i = 0; i < sums.length; i ++){
                sum += parseFloat(sums[i]);
            }

            $("#auction-total_sum").val(sum);
        }
    });

    $(document).on("click", ".panel .close", function (e) {
        e.preventDefault();

        $(this).closest(".panel").remove();
        correctNumber();
    });

    function correctNumber (){
        $("#tns .panel").each(function (i, el) {
            $(el).find(".number").text("#" + (i + 1));
        });
    }

    correctNumber ();
JS;

$this->registerJs($JS, 3);
