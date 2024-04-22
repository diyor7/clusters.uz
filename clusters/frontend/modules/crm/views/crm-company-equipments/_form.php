<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\crm\CrmCompanyEquipments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="crm-company-equipments-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-8">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'parametres')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-4">

            <?= $form->field($model, 'category_id')->dropDownList($model->categories) ?>

            <?= $form->field($model, 'equipment_count')->textInput() ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('crm', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
