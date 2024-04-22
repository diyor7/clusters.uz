<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\customer\models\SearchProcurementPlan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="procurement-plan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'company_id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'year') ?>

    <?= $form->field($model, 'kvartal') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'code') ?>

    <?php // echo $form->field($model, 'functionality') ?>

    <?php // echo $form->field($model, 'technicality') ?>

    <?php // echo $form->field($model, 'unit') ?>

    <?php // echo $form->field($model, 'unit_type') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
