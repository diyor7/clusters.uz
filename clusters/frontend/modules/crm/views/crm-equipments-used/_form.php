<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\crm\CrmEquipmentsUsed */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="crm-equipments-used-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'date')->textInput(['maxlength' => true, 'type' => 'date']) ?>
            <?= $form->field($model, 'equipment_id')->dropDownList($model->equipments) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'count')->textInput() ?>
            <?= $form->field($model, 'lifetime')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('crm', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>