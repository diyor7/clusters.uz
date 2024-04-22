<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = getTranslate('test');
$this->params['breadcrumbs'][] = $this->title;
?>
<main>
    <div class="container-fluid my-60 mh-50">
        <div class="row justify-content-md-center pt-30">
            <div class="col-6 col-xxl-4">
                <div class="border rounded-lg bg-white p-30 fs-15 position-relative ">
                    <h4 class="title mt-0 mb-30 font-weight-bold">Вход в систему</h4>
                    <?php $form =  \yii\bootstrap\ActiveForm::begin([
                        'method' => 'POST',
                    ]) ?>

                    <div class="form-group">
                        <label class="fw-semi-bold">FILE:</label>
                        <?= $form->field($model, 'file')->fileInput() ?>
                    </div>


                    <div class="mt-30">
                        <?= Html::submitButton(t('OK'), ['class' => 'btn btn-primary fs-15 py-5 px-35 mr-10']); ?>
                    </div>
                    <?php \yii\bootstrap\ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</main>