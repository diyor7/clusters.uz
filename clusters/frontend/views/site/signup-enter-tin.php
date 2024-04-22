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
    <div class="login-form py-45 px-60 mx-auto col-lg-4 col-md-6 col-sm-12 font-family-roboto">
        <a class="text-dark mb-10 d-inline-block" href="<?=toRoute('/site/select-signup')?>"><?=t("Назад")?></a>
        <?php $form = ActiveForm::begin([
            'action' => toRoute('/site/signup-trader'),
            'method' => 'GET',
            'options' => [
                'enctype' => 'multipart/form-data',
                'class' => 'form'
            ]
        ]) ?>

        <h1 class="font-family-monsterrat mb-40 my-5"><?= $this->title ?></h1>

        <div class="form-group mb-25">
            <?= MaskedInput::widget([
                'mask' => '999999999',
                'name' => "tin",
                'options' => [
                    'class' => 'form-control py-20 px-30 h-auto',
                    'placeholder' => t("Введите ваш инн")
                ]
            ]) ?>
        </div>

        <div class="form-group">
            <div class="text-center">
                <?= Html::submitButton(t('Продолжить'), ['class' => 'btn btn-secondary rounded-pill py-5 px-45 h-auto']); ?>
            </div>
        </div>
        <!-- 
        <p class="text-center"><a class="login-form__eimzo-link primary-text" href="<?= toRoute('/site/login-ecp') ?>"><?= t("Войти") ?></a></p>
        <p class="text-center"><a class="login-form__eimzo-link primary-text" href="<?= toRoute('/site/signup') ?>"><?= t("Зарегистрироваться как покупатель") ?></a></p> -->

        <?php \yii\bootstrap\ActiveForm::end(); ?>
    </div>
</div>