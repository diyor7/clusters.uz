<?php

use common\models\Category;
use common\models\Order;
use common\models\Product;
use common\models\Region;
use common\models\Tn;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

$this->title = $model->isNewRecord ? t("Добавить ТН ВЭД") : t("Редактировать ТН ВЭД");

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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous">

<?= $this->render("../layouts/_nav", [
    'btn_title' => t("Назад"),
    'btn_url' => toRoute('/user/product/tn'),
    'breadcrumb_title' => t("Мои товары"),
    'breadcrumb_url' => toRoute('/user/product/tn')
]) ?>

<div class="new-bg-different py-30">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?= $this->render("../layouts/_menu") ?>
            </div>
            <div class="col-md-9">
                <div class="cabinet__content">
                    <div class="row justify-content-md-center">
                        <div class="col-md-12 col-xxl-12">
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
                                            <?= $form->field($model, 'tn_id')->dropDownList([], [
                                                'class' => 'form-control tn-ajax px-30',
                                                'prompt' => t(" - Выберите - ")
                                            ]) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <?= Html::submitButton($model->isNewRecord ? t('Добавить') : t("Редактировать"), ['class' => 'btn btn-success']); ?>
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
});

$(".product-tab .nav-link").on("click", function (e) {
    $(".product-tab .nav-link").removeClass("active");
    $(this).addClass("active");
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