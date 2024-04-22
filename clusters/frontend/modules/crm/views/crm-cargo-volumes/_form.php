<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\crm\CrmCargoVolumes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="crm-cargo-volumes-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'date')->textInput(['type' => 'date']) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'product_id')->dropDownList(\common\models\crm\CrmProduct::getProducts()) ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'size_loaded')->textInput() ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'size_delivered')->textInput() ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'size_remaining')->textInput() ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'unit_id')->dropDownList(\common\models\crm\CrmProduct::getUnits()) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('crm', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
