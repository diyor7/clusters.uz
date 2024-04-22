<?php

use common\models\crm\CrmProduct;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\crm\CrmMining */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="crm-mining-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-4">
            <?= $form->field($model, 'date')->textInput(['maxlength' => true, 'type' => 'date']) ?>
            <?= $form->field($model, 'product_id')->dropDownList(CrmProduct::getProducts()) ?>
            <?= $form->field($model, 'mine_id')->dropDownList(CrmProduct::getMines()) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'type')->dropDownList(Yii::$app->params['mining-types']) ?>
            <?= $form->field($model, 'capacity')->textInput() ?>
            <?= $form->field($model, 'capacity_next')->textInput() ?>

        </div>
        <div class="col-4">
<!--            --><?php //= $form->field($model, 'size')->textInput() ?>
            <?= $form->field($model, 'unit_id')->dropDownList(CrmProduct::getUnits()) ?>
            <?= $form->field($model, 'capacity_next_unit_id')->dropDownList(CrmProduct::getUnits()) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('crm', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
