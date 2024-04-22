<?php

use common\models\crm\CrmProduct;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\crm\CrmProductionVolumes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="crm-production-volumes-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-4">
    <?= $form->field($model, 'date')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'product_id')->dropDownList(CrmProduct::getProducts()) ?>

    <?= $form->field($model, 'unit_id')->dropDownList(CrmProduct::getUnits()) ?>
        </div>
        <div class="col-4">
    <?= $form->field($model, 'stock_volume')->textInput() ?>

    <?= $form->field($model, 'defective_volume')->textInput() ?>

    <?= $form->field($model, 'next_volume')->textInput() ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('crm', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
