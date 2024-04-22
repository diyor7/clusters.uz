<?php

use common\models\Company;
use common\models\Region;
use nenad\passwordStrength\PasswordInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = getTranslate('Зарегистрироваться как продавец');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="position-relative d-flex align-items-center header-home__block-form">
    <div class="login-form py-45 px-60 mx-auto col-lg-5 col-md-6 col-sm-12 font-family-roboto">
        <?php $form = ActiveForm::begin([
            'action' => toRoute('/site/signup-trader?tin='.$tin),
            'method' => 'POST',
            'options' => [
                'enctype' => 'multipart/form-data',
                'class' => 'form'
            ]
        ]) ?>

        <a class="text-dark mb-10 d-inline-block" href="<?= toRoute('/site/signup-trader') ?>"><?= t("Назад") ?></a>

        <h1 class="font-family-monsterrat mb-40 my-5"><?= $this->title ?></h1>

        <h5 class="text-center"><?= t("Организация") ?></h5>
        <div class="form-group mb-25">
            <?= $form->field($model, 'company_tin')->widget(MaskedInput::class, [
                'mask' => '999999999',
                'options' => [
                    'class' => 'form-control py-20 px-30 h-auto',
                    'placeholder' => $model->getAttributeLabel('company_tin'),
                ]
            ]) ?>
        </div>
        <div class="form-group mb-25">
            <?= $form->field($model, 'company_name')->input('text', [
                'placeholder' => $model->getAttributeLabel('company_name'),
                'class' => 'form-control py-20 px-30 h-auto'
            ]) ?>
        </div>
        <div class="form-group mb-25">
            <?= $form->field($model, 'company_type')->dropDownList(Company::getTypes(), [
                'class' => 'form-control py-20 px-30 h-auto',
                'prompt' => t(" - Выберите тип организации - ")
            ]) ?>
        </div>
        <div class="form-group mb-25">
            <?= $form->field($model, 'company_region_id')->dropDownList(Region::getTree(), [
                'class' => 'form-control py-20 px-30 h-auto',
                'prompt' => t(" - Выберите регион - ")
            ]) ?>
        </div>
        <div class="form-group mb-25">
            <?= $form->field($model, 'company_bank_account')->widget(MaskedInput::class, [
                'mask' => '99999999999999999999',
                'options' => [
                    'class' => 'form-control py-20 px-30 h-auto',
                    'placeholder' => $model->getAttributeLabel('company_bank_account'),
                ]
            ]) ?>
        </div>
        <div class="form-group mb-25">
            <?= $form->field($model, 'company_bank_mfo')->widget(MaskedInput::class, [
                'mask' => '99999',
                'options' => [
                    'class' => 'form-control py-20 px-30 h-auto',
                    'placeholder' => $model->getAttributeLabel('company_bank_mfo'),
                ]
            ]) ?>
        </div>
        <div class="form-group mb-25">
            <?= $form->field($model, 'company_phone')->widget(MaskedInput::className(), [
                'mask' => '\+\9\9\8999999999',
                'options' => [
                    'placeholder' => $model->getAttributeLabel('company_phone'),
                    'class' => 'form-control py-20 px-30 h-auto'
                ]
            ]) ?>
        </div>
        <div class="form-group mb-25">
            <?= $form->field($model, 'company_site')->input('text', [
                'placeholder' => $model->getAttributeLabel('company_site'),
                'class' => 'form-control py-20 px-30 h-auto'
            ]) ?>
        </div>
        <div class="form-group mb-25">
            <?= $form->field($model, 'company_email')->input('text', [
                'placeholder' => $model->getAttributeLabel('company_email'),
                'class' => 'form-control py-20 px-30 h-auto'
            ]) ?>
        </div>
        <!-- <div class="form-group mb-25">
            <?= $form->field($model, 'company_employees')->input('text', [
                'placeholder' => $model->getAttributeLabel('company_employees'),
                'class' => 'form-control py-20 px-30 h-auto'
            ]) ?>
        </div> -->
        <div class="form-group mb-25">
            <?= $form->field($model, 'company_address')->textarea([
                'placeholder' => $model->getAttributeLabel('company_address'),
                'class' => 'form-control py-20 px-30 h-auto'
            ]) ?>
        </div>
        <h5 class="text-center"><?= t("Пользователь") ?></h5>

        <div class="form-group mb-25">
            <?= $form->field($model, 'full_name')->input('text', [
                'placeholder' => $model->getAttributeLabel('full_name'),
                'class' => 'form-control py-20 px-30 h-auto'
            ]) ?>
        </div>

        <div class="form-group mb-25">
            <?= $form->field($model, 'email')->input('email', [
                'placeholder' => $model->getAttributeLabel('email'),
                'class' => 'form-control py-20 px-30 h-auto'
            ]) ?>
        </div>

        <div class="form-group mb-25">
            <?= $form->field($model, 'username')->widget(MaskedInput::className(), [
                'mask' => '\+\9\9\8999999999',
                'options' => [
                    'placeholder' => $model->getAttributeLabel('username'),
                    'class' => 'form-control py-20 px-30 h-auto'
                ]
            ]) ?>
        </div>

        <div class="form-group mb-25">
            <?= $form->field($model, 'password')->input('password', [
                'placeholder' => $model->getAttributeLabel('password'),
                'class' => 'form-control py-20 px-30 h-auto'
            ]) ?>
        </div>

        <div class="form-group mb-25">
            <?= $form->field($model, 'confirm_password')->input('password', [
                'placeholder' => $model->getAttributeLabel('confirm_password'),
                'class' => 'form-control py-20 px-30 h-auto'
            ]) ?>
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

        <p class="text-center"><a class="login-form__eimzo-link primary-text" href="<?= toRoute('/site/login') ?>"><?= t("Войти") ?></a></p>
        <p class="text-center"><a class="login-form__eimzo-link primary-text" href="<?= toRoute('/site/login-ecp') ?>"><?= t("Войти через ЭЦП") ?></a></p>
        <p class="text-center"><a class="login-form__eimzo-link primary-text" href="<?= toRoute('/site/signup') ?>"><?= t("Зарегистрироваться как покупатель") ?></a></p>

        <?php \yii\bootstrap\ActiveForm::end(); ?>
    </div>
</div>