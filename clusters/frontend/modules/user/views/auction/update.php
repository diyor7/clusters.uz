<?php

use common\models\Category;
use common\models\Condition;
use common\models\Region;
use yii\bootstrap\Html;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;
$this->title = t("Редактировать аукцион");
$old_category = [];
if(!$model->isNewRecord){
    $old_category = [
        $model->category_id => $model->category->title
    ];
}

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
                <div class="shadow rounded bg-white p-20 fs-15">
                    <?php $form =  \yii\bootstrap\ActiveForm::begin([
                        'method' => 'POST',
                        'options' => [
                            'class' => 'form'
                        ],
                        'id' => "product-form"
                    ]) ?>
                    <div class="tab-content pt-15 mt-15 pb-15" id="pills-tabContent">
                        <div class="tab-pane font-family-roboto fade show active" id="pill-1" role="tabpanel"
                            aria-labelledby="pill-1-tab">

                            <div class="form-group mb-25">
                                <?= $form->field($model, 'category_id')->dropDownList(
                                    [
                                        $old_category
                                    ], 
                                    [
                                        'class' => 'form-control parent-category-ajax px-30',
                                        'prompt' => t(" - Выберите - ")
                                    ],
                                );
                                
                                ?>
                            </div>

                            <div id="root">
                                <h5 class="text-center"><?=t("НАИМЕНОВАНИЕ ЗАКАЗА")?></h5>

                                <input type="text" class="form-control" placeholder="<?=t("Поиск по товарам")?>"
                                    id="product-search" value="<?=$model->category->title?>">

                                <div id="products" class="my-25"
                                    style="height: 350px; overflow-y: scroll; padding: 10px; border: 3px solid #f8f8f8">
                                    <p class="text-center"><?= t("Продукты показываются по поиску") ?></p>
                                </div>

                                <div id="tovars">
                                    <?php foreach ($tovars as $tovar) : ?>
                                    <?php $m = Category::findOne($tovar->category_id); ?>
                                    <?= $this->render("@frontend/modules/auction/views/default/_category-form", ['model' => $m, 'existModel' => $tovar]) ?>
                                    <?php endforeach ?>
                                </div>


                                <div id="condition_box" class="form-group border-top-1 p-1 border-dark">
                                    <p class="p-10 condition_label"><?=t("Особые условия")?></p>

                                    <?php
                                    $condition_ids = [];
                                    
                                            foreach ($model->auctionConditions as $auctionCondition) :
                                                $condition_ids[]=$auctionCondition->condition_id;
                                                $cat_name = $auctionCondition->texts;
                                                $de_inputs = json_decode($auctionCondition->inputs);
                                                // echo "<h1>"; var_dump($condition_ids); echo "</h1>"; die;
                                                if(is_array($de_inputs))
                                                    foreach ($de_inputs as $x){
                                                        if(is_array($x)){
                                                            $x = $x[0];
                                                        }
                                                        $cat_name = preg_replace("/:X/", '<input type="text" value="'. $x .'" name="condition_inputs['. $auctionCondition->condition_id .'][]">', $cat_name, 1 );
                                                    }

                                        ?>
                                    <div class="p-3 background-gainsboro my-2 d-flex justify-content-between added_div">
                                        <p class="m-0"><?= $cat_name ?></p>
                                        <p class="m-0 x_cancel-box">
                                            <button type="button" data-id="<?=$auctionCondition->condition_id?>"
                                                class="x_cancel border-0 b-radius-50 px-2 py-1 text-white">X</button>
                                        </p>
                                    </div>

                                    <?php endforeach; ?>

                                </div>

                                <div class="form-group bt-25 mb-55">
                                    <div id="products" class="my-15"
                                        style="height: 350px; overflow-y: scroll; padding: 10px; border: 3px solid #f8f8f8">
                                        <div class="row mx-0">
                                            <?php foreach (Condition::find()->all() as $md) : ?>
                                            <div class="checkbox px-3 py-2 background-gainsboro my-1 w-100 b-radius-5">
                                                <label class="m-0">
                                                    <input type="checkbox" class="condition_checkbox"
                                                        <?=in_array($md->id, $condition_ids) ? 'checked' : ''?>
                                                        name="Auction[condition_ids][]" value="<?= $md->id ?>"
                                                        data-title="<?= htmlspecialchars($md->title) ?>">
                                                    <?= $md->title ?>
                                                </label>
                                            </div>
                                            <?php endforeach; ?>

                                        </div>
                                    </div>
                                    <button type="button" id="condition_checkbox_button"
                                        class="btn btn-primary float-right"><?=t("Добавить")?></button>

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
                                <h5 class="text-center"><?=t("Адрес доставки")?></h5>
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
$category_form_url = toRoute('/auction/default/category-form');

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
        }, 500);
    });

    $("#auction-category_id").change(function (){
        $("#products").html("");
        $("#product-search").val("");
        $("#tovars").html ("");
    });

    $(document).on("click", ".select-tovar", function (){
        var tovar_id = $(this).data("tovar_id");

        $.ajax({
            url: "$category_form_url?category_id=" + tovar_id,
            method: "GET"
        }).done(function (res) {
            $("#tovars").append(res);
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
        $("#tovars").find(".calc-r").each((i, el) => {
            console.log(el);
            if (el.value) {
                sums.push(el.value);
            }
        });

        if (sums.length == $("#tovars").find(".calc-r").length) {
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
        $("#tovars .panel").each(function (i, el) {
            $(el).find(".number").text("#" + (i + 1));
        });
    }

    correctNumber ();
    $(document).ready(function(){
        $("#condition_checkbox_button").click(function (){
            var selected_condition_checkbox = [];
            $(".added_div").remove();
            
            $('input.condition_checkbox:checked').each(function() {
                let id = $(this).attr("value");
                let title = $(this).data("title");
                let res = title.replace(/:X/g, "<input type='text' name='condition_inputs[" + id + "][]' required>");
                
                res = res.length > 0 ? res : title;
                //Auction[condition_ids][]
                
                var p_a = $("<p class='m-0 x_cancel-box'><button type='button' data-id=" + id + " class='x_cancel border-0 b-radius-50 px-2 py-1 text-white'>X</button></p>" );
                var p_text = $("<p>", {"class": "m-0"}).prepend(res);
                
                var div = $("<div>", {"class": "p-3 background-gainsboro my-2 d-flex justify-content-between added_div"});
    
                
                div.append(p_text);
                div.append(p_a);
                $("#condition_box").append(div);
                
                // selected_condition_checkbox.push({id,title});
            });
            
        });
        
    });
    $(document).on("click", ".x_cancel", function() {
        let id = $(this).data("id");
        $('input.condition_checkbox:checked').each(function() {
            if($(this).attr("value") == id){
                $(this).prop('checked', false);
            }
        })
        $(this).parent().parent().remove(); 
    });
    
    
JS;

$this->registerJs($JS, 3);