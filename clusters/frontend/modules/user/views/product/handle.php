<?php

use common\models\Category;
use common\models\Order;
use common\models\Product;
use common\models\Region;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

$this->title = $model->isNewRecord ? t("Добавить товар") : t("Редактировать товар");

$this->params['breadcrumbs'][] = array(
    'label' => t("Личный кабинет"),
    'url' => toRoute('/user')
);
$this->params['breadcrumbs'][] = array(
    'label' => t("Мои товары"),
    'url' => toRoute('/user/product')
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
                <div class="cabinet__content shadow">
                    <ul class="nav nav-cabinet product-tab fs-15" id="pills-tab" role="tablist">
                        <li class="nav-item position-relative pb-30 mr-15">
                            <a class="nav-link p-0 active" id="pill-1-tab" data-toggle="tab" href="#pill-1" role="tab" aria-controls="pill-1">
                                <?= t("Основные данные") ?> <i class="fa fa-exclamation"></i>
                            </a>
                        </li>
                        <li class="nav-item position-relative  pb-30 mx-15">
                            <a class="nav-link p-0" data-toggle="tab" id="pill-2-tab" href="#pill-2" role="tab" aria-controls="pill-2">
                                <?= t("Характеристики") ?> <i class="fa fa-exclamation"></i>
                            </a>
                        </li>
                        <li class="nav-item position-relative  pb-30 mx-15">
                            <a class="nav-link p-0" data-toggle="tab" href="#pill-3" role="tab" aria-controls="pill-3">
                                <?= t("Цены и количество") ?> <i class="fa fa-exclamation"></i>
                            </a>
                        </li>
                        <li class="nav-item position-relative  pb-30 mx-15">
                            <a class="nav-link p-0" data-toggle="tab" href="#pill-4" role="tab" aria-controls="pill-4">
                                <?= t("Доставка") ?> <i class="fa fa-exclamation"></i>
                            </a>
                        </li>
                        <li class="nav-item position-relative  pb-30 mx-15">
                            <a class="nav-link p-0" data-toggle="tab" href="#pill-5" role="tab" aria-controls="pill-5">
                                <?= t("Картинки") ?> <i class="fa fa-exclamation"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="row justify-content-md-center">
                        <div class="col-md-12 col-xxl-12">
                            <div class="rounded bg-white p-20 fs-15">
                                <?php $form =  \yii\bootstrap\ActiveForm::begin([
                                    'method' => 'POST',
                                    'options' => [
                                        'class' => 'form'
                                    ],
                                    'id' => "product-form"
                                ]) ?>
                                <div class="tab-content pb-15" id="pills-tabContent">
                                    <div class="tab-pane font-family-roboto fadefade show active" id="pill-1" role="tabpanel" aria-labelledby="pill-1-tab">
                                        <div class="form-group mb-25">
                                            <?= $form->field($model, 'title')->input('text', [
                                                'class' => 'form-control py-20 px-30'
                                            ]) ?>
                                        </div>
                                        <div class="form-group mb-25">
                                            <?= $form->field($model, 'tn_id')->dropDownList([], [
                                                'class' => 'form-control tn-ajax px-30',
                                                'prompt' => t(" - Выберите - ")
                                            ]) ?>
                                        </div>
                                        <div class="form-group mb-25">
                                            <?= $form->field($model, 'description')->textarea([
                                                'class' => 'form-control py-20 px-30',
                                                'rows' => 8
                                            ]) ?>
                                        </div>
                                    </div>

                                    <div class="tab-pane font-family-roboto fade" id="pill-2" role="tabpanel" aria-labelledby="pill-2-tab">
                                        <div id="properties"></div>


                                        <div class="form-group mb-25">
                                            <?= $form->field($model, 'warranty_period')->input('number', [
                                                'class' => 'form-control py-20 px-30'
                                            ]) ?>
                                        </div>
                                        <div class="form-group mb-25">
                                            <?= $form->field($model, 'warranty_period_type')->dropDownList(Product::getWarrantyPeriodTypes(), [
                                                'class' => 'form-control px-30'
                                            ]) ?>
                                        </div>

                                        <!-- <div class="form-group mb-25">
                                            <?= $form->field($model, 'status')->dropDownList([
                                                1 => t("Активный"),
                                                0 => t("Архив"),
                                            ], [
                                                'class' => 'form-control px-30'
                                            ]) ?>
                                        </div> -->

                                    </div>
                                    <div class="tab-pane font-family-roboto fade" id="pill-3" role="tabpanel" aria-labelledby="pill-3-tab">
                                        <div class="form-group mb-25">
                                            <?= $form->field($model, 'price')->input('number', [
                                                'class' => 'form-control py-20 px-30'
                                            ]) ?>
                                        </div>

                                        <!-- <div class="form-group mb-25">
                                            <?= $form->field($model, 'price_old')->input('number', [
                                                'class' => 'form-control py-20 px-30'
                                            ]) ?>
                                        </div> -->
                                        <div class="form-group mb-25">
                                            <?= $form->field($model, 'quantity')->input('number', [
                                                'class' => 'form-control py-20 px-30'
                                            ]) ?>
                                        </div>
                                        <div class="form-group mb-25">
                                            <?= $form->field($model, 'min_order')->input('number', [
                                                'class' => 'form-control py-20 px-30'
                                            ]) ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane font-family-roboto fade" id="pill-4" role="tabpanel" aria-labelledby="pill-4-tab">
                                        <div class="form-group mb-25">
                                            <?= $form->field($model, 'delivery_period')->input('number', [
                                                'class' => 'form-control py-20 px-30'
                                            ]) ?>
                                        </div>

                                        <div class="form-group mb-25">
                                            <?= $form->field($model, 'delivery_period_type')->dropDownList(Product::getDeliveryPeriodTypes(), [
                                                'class' => 'form-control px-30'
                                            ]) ?>
                                        </div>
                                        <div class="form-group mb-25">
                                            <?= $form->field($model, 'delivery_type')->dropDownList(
                                                Order::getDeliveryTypes(),
                                                [
                                                    'class' => 'form-control px-30',
                                                ]
                                            ) ?>
                                        </div>
                                        <div class="form-group mb-25">
                                            <?= $form->field($model, 'delivery_regions')->dropDownList(
                                                Region::getTree(),
                                                [
                                                    'class' => 'form-control px-30 select2',
                                                    'multiple' => true
                                                ]
                                            ) ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane font-family-roboto fade" id="pill-5" role="tabpanel" aria-labelledby="pill-5-tab">
                                        <div class="form-group mb-25">
                                            <div id="old-files" class="d-flex mb-25 flex-wrap">
                                                <?php if ($model->image) : ?>
                                                    <div class="file mr-15 mb-25">
                                                        <a href="<?= $model->path ?>" target="_blank" class="preview-file mr-0 d-flex align-items-center justify-content-center">
                                                            <img src="<?= $model->path ?>" alt="">
                                                        </a>
                                                        <a href="#!" class="text-center d-block mt-10 delete-product-image" data-product_id="<?= $model->id ?>">
                                                            <i class="fa fa-trash"></i> <?= t("Удалить") ?>
                                                        </a>
                                                    </div>
                                                <?php endif ?>

                                                <?php foreach ($model->productImages as $pi) : ?>
                                                    <div class="file mr-15 mb-25">
                                                        <a href="<?= $pi->path ?>" target="_blank" class="preview-file d-flex mr-0 align-items-center justify-content-center">
                                                            <img src="<?= $pi->path ?>" alt="">
                                                        </a>
                                                        <a href="#!" class="text-center d-block mt-10 delete-product-image" data-image_id="<?= $pi->id ?>">
                                                            <i class="fa fa-trash"></i> <?= t("Удалить") ?>
                                                        </a>
                                                    </div>
                                                <?php endforeach ?>
                                            </div>
                                            <div class="d-flex">
                                                <div id="files" class="d-flex flex-wrap">
                                                    <div class="file">
                                                        <a href="#!" class="preview-file d-flex align-items-center justify-content-center">
                                                            <i class="fa fa-2x fa-upload"></i>
                                                        </a>
                                                        <a href="#!" class="text-center d-none mt-10 delete-preview-image mr-15">
                                                            <i class="fa fa-trash"></i> <?= t("Удалить") ?>
                                                        </a>
                                                        <?= $form->field($model, 'files[]')->fileInput(['class' => 'd-none myfile'])->label(false) ?>
                                                    </div>
                                                </div>

                                                <a href="#!" class="add-another-file  align-items-center justify-content-center d-none">
                                                    <i class="fa fa-2x fa-plus"></i>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <?= Html::submitButton($model->isNewRecord ? t('Добавить') : t("Редактировать"), ['class' => 'btn btn-success ']); ?>
                                </div>
                                <?php \yii\bootstrap\ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous">

<?php $this->registerJs('
$("#product-category_id").change(function (e){
    loadProperties(e.target.value' . ($model->id ? ', ' . $model->id : '') . ');
});

loadProperties($("#product-category_id").val()' . ($model->id ? ', ' . $model->id : '') . ');

function loadProperties(category_id, product_id) {
    $("#properties").load("' . toRoute('/ajax/load-properties?category_id=') . '" + category_id + (product_id ? "&product_id=" + product_id : ""));
}

$(".add-another-file").click(function (){
    var clone = $("#files").children().eq(0).clone();
    clone.find("input").val("");
    clone.appendTo($("#files"));
    clone.find("img").remove();
});

$(".product-tab .nav-link").on("click", function (e) {
    $(".product-tab .nav-link").removeClass("active");
    $(this).addClass("active");
});

$(document).on("click", ".preview-file", function (){
    $(this).closest(".file").find(".field-product-files").find("input").trigger("click");
});

$(document).on("click", ".delete-product-image", function (e){
    e.preventDefault();
    var product_id = $(this).data("product_id");
    var image_id = $(this).data("image_id");
    var _this = this;

    if (product_id){
        $.ajax({
            url: "' . toRoute("/cabinet/product/delete-product-image") . '",
            method: "GET",
            data: {product_id: product_id}
        }).done(function (res){
            if (res.status == "success"){
                $(_this).closest(".file").remove();
            }
        });
    } else if (image_id){
        $.ajax({
            url: "' . toRoute("/cabinet/product/delete-image") . '",
            method: "GET",
            data: {image_id: image_id}
        }).done(function (res){
            if (res.status == "success"){
                $(_this).closest(".file").remove();
            }
        });
    }
});

$(document).on("click", ".delete-preview-image", function (e){
    e.preventDefault();
    $(this).closest(".file").remove();
});

$(document).on("change", ".myfile", function (){
    var _this = this;

    if (this.files.length > 0){
        var file = this.files[0];
        var reader = new FileReader();
        var url = reader.readAsDataURL(file);

        reader.onloadend = function (e) {
            $(_this).closest(".file").find(".preview-file img").remove();
            $(_this).closest(".file").find(".preview-file").prepend($("<img>").attr("src", reader.result));
            $(".add-another-file").trigger("click");
            $(_this).closest(".file").find(".delete-preview-image").removeClass("d-none").addClass("d-block");
        }
    } else {
        $(_this).closest(".file").remove();
    }
});

$("#product-form").on("afterValidateAttribute", function (event, attribute, messages) {
    $("#pills-tabContent .tab-pane").each(function(i, el){
        if ($(el).find(".has-error").length > 0){
            $("#pills-tab li.nav-item").eq(i).addClass("has-error");
        } else {
            $("#pills-tab li.nav-item").eq(i).removeClass("has-error");
        }
    });
});

$(".select2").select2({
    multiple: true
});

function checkDelivery (){
    if ($("#product-delivery_type").val() == 2){
        $(".field-product-delivery_regions").fadeOut(200);
    } else {
        $(".field-product-delivery_regions").fadeIn(200);
    }
}

checkDelivery ();

$("#product-delivery_type").change(function (){
    checkDelivery ();
});

$(".tn-ajax").select2({
    ajax: {
      url: "/site/tns",
      dataType: "json",
      data: function (data) {
            return {
                query: data.term
            };
        },
    },
    width: "100%",
    language: "ru",
    minimumInputLength: 3
});

', \yii\web\View::POS_END); ?>