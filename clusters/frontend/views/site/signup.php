<?php

use nenad\passwordStrength\PasswordInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = getTranslate('Зарегистрироваться как покупатель');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="position-relative d-flex align-items-center header-home__block-form">
    <div class="login-form py-45 px-60 mx-auto col-lg-5 col-md-6 col-sm-12 font-family-roboto">
        <?php $form = ActiveForm::begin([
            'action' => toRoute('/site/signup'),
            'method' => 'POST',
            'options' => [
                'enctype' => 'multipart/form-data',
                'class' => 'form'
            ]
        ]) ?>

        <h1 class="font-family-monsterrat mb-40 my-5"><?= $this->title ?></h1>

        <div class="form-group mb-25">
            <?= $form->field($model, 'full_name')->input('text', [
                'placeholder' => $model->getAttributeLabel('full_name') . ' *',
                'class' => 'form-control py-20 px-30 h-auto'
            ])->label(false) ?>
        </div>

        <div class="form-group mb-25">
            <?= $form->field($model, 'email')->input('email', [
                'placeholder' => $model->getAttributeLabel('email'),
                'class' => 'form-control py-20 px-30 h-auto'
            ])->label(false) ?>
        </div>

        <div class="form-group mb-25">
            <?= $form->field($model, 'username')->widget(MaskedInput::className(), [
                'mask' => '\+\9\9\8999999999',
                'options' => [
                    'placeholder' => $model->getAttributeLabel('username') . ' *',
                    'class' => 'form-control py-20 px-30 h-auto'
                ]
            ])->label(false) ?>
        </div>

        <div class="form-group mb-25">
            <?= $form->field($model, 'password')->input('password', [
                'placeholder' => $model->getAttributeLabel('password') . ' *',
                'class' => 'form-control py-20 px-30 h-auto'
            ])->label(false) ?>
        </div>

        <div class="form-group mb-25">
            <?= $form->field($model, 'confirm_password')->input('password', [
                'placeholder' => $model->getAttributeLabel('confirm_password') . ' *',
                'class' => 'form-control py-20 px-30 h-auto'
            ])->label(false) ?>
        </div>

        <div class="form-group">
            <?= $form->field($model, 'agreement', ['template' => '
                <div class="form-check py-20 w-100 px-0 mx-0">
                    {input}
                    <label class="form-check-label px-20 gray-text ml-5" for="signupform-agreement">' . $model->getAttributeLabel('agreement') . '</label>
                    {error}
                </div>
            '])->input('checkbox', [
                'class' => 'form-check-input ml-0'
            ])->label(false) ?>
            <div class="text-center">
                <?= Html::submitButton(t('Зарегистрироваться'), ['class' => 'btn btn-secondary rounded-pill py-5 px-45 h-auto']); ?>
            </div>
        </div>

        <p class="text-center"><a class="login-form__eimzo-link primary-text" href="<?= toRoute('/site/login-ecp') ?>"><?= t("Войти") ?></a></p>
        <p class="text-center"><a class="login-form__eimzo-link primary-text" href="<?= toRoute('/site/signup-trader') ?>"><?= t("Зарегистрироваться как продавец") ?></a></p>

        <?php \yii\bootstrap\ActiveForm::end(); ?>
    </div>
</div>