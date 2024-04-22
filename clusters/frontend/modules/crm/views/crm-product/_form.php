<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\crm\CrmProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="crm-product-form w-100">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-8">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'category_id')->dropDownList(
                $model->category ? [$model->category->id => $model->category->title] : [], [
                'class' => 'form-control category-ajax px-30',
                'prompt' => t(" - Выберите - ")
            ]) ?>
            <?= $form->field($model, 'type_id')->dropDownList(Yii::$app->params['crm-product-types']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('crm', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs('
$("#crmproduct-category_id").change(function (e){
    loadProperties(e.target.value' . ($model->id ? ', ' . $model->id : '') . ');
});

loadProperties($("#crmproduct-category_id").val()' . ($model->id ? ', ' . $model->id : '') . ');

function loadProperties(category_id, product_id) {
    $("#properties").load("' . toRoute('/ajax/load-properties?category_id=') . '" + category_id + (product_id ? "&product_id=" + product_id : ""));
}
', \yii\web\View::POS_END); ?>