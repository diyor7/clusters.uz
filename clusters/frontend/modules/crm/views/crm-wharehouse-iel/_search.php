<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\crm\CrmWharehouseIelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="crm-wharehouse-iel-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'prduct_type_id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'product_unit_id') ?>

    <?= $form->field($model, 'balance_from') ?>

    <?php // echo $form->field($model, 'balance_out') ?>

    <?php // echo $form->field($model, 'balance_in') ?>

    <?php // echo $form->field($model, 'balance_left') ?>

    <?php // echo $form->field($model, 'company_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('crm', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('crm', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
