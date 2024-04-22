<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\crm\CrmWorkersEmployed */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="crm-workers-employed-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'date')->textInput(['maxlength' => true, 'type' => 'date']) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'title')->textInput() ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'workertype_id')->dropDownList($model->employeeActivityTypes) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'count')->textInput() ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'lifetime')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('crm', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
