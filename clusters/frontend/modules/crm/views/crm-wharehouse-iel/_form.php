<?php

use common\models\crm\CrmProduct;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\crm\CrmWharehouseIel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="crm-wharehouse-iel-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-4">
            <?= $form->field($model, 'prduct_type_id')->dropDownList(Yii::$app->params['crm-product-types']) ?>
        </div>
        <div class="col-4">

            <?= $form->field($model, 'product_id')->dropDownList(CrmProduct::getProducts()) ?>

        </div>
        <div class="col-4">
            <?= $form->field($model, 'product_unit_id')->dropDownList(CrmProduct::getUnits()) ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'balance_from')->textInput() ?>
        </div>
        <div class="col-3">

            <?= $form->field($model, 'balance_out')->textInput() ?>
        </div>
        <div class="col-3">

            <?= $form->field($model, 'balance_in')->textInput() ?>
        </div>
        <div class="col-3">

            <?= $form->field($model, 'balance_left')->textInput() ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('crm', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
