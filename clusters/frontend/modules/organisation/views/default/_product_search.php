<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search row">

    <?php $form = ActiveForm::begin([
//        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
            'class' => 'row bg-gray p-30 ml-20 border'
        ],
    ]); ?>

    <div class="col-4">
        <?= $form->field($model, 'name') ?>
    </div>
    <div class="col-4">
        <?= $form->field($model, 'price') ?>
    </div>
    <div class="col-4">
        <?= $form->field($model, 'code') ?>
    </div>

    <div class="col-4">
        <?= Html::submitButton(Yii::t('frontend', 'Поиск'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php // echo $form->field($model, 'views') ?>

    <?php // echo $form->field($model, 'units_measure_id') ?>

    <?php // echo $form->field($model, 'quarter_id') ?>

    <?php //  echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>


    <?php ActiveForm::end(); ?>

</div>
