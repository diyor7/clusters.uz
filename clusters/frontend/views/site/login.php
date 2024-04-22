<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = getTranslate('Авторизация');
$this->params['breadcrumbs'][] = $this->title;
?>
<main>
    <div class="container-fluid my-60 mh-50">
        <div class="row justify-content-md-center pt-30">
            <div class="col-6 col-xxl-4">
                <div class="border rounded-lg bg-white p-30 fs-15 position-relative ">
                    <h4 class="title mt-0 mb-30 font-weight-bold">Вход в систему</h4>
                    <?php $form =  \yii\bootstrap\ActiveForm::begin([
                        'action' => toRoute(['/site/login', 'test' => $test]),
                        'method' => 'POST',
                        'options' => [
                            'class' => ''
                        ]
                    ]) ?>
                    <div class="form-group">
                        <label class="fw-semi-bold">Логин:</label>
                        <?= $form->field($model, 'username')->widget(MaskedInput::className(), [
                            'mask' => '\+\9\9\8999999999',
                            'options' => [
                                'placeholder' => $model->getAttributeLabel('username'),
                                'class' => 'form-control '
                            ]
                        ])->label(false) ?>
                    </div>
                    <div class="form-group">
                        <label class="fw-semi-bold">Пароль:</label>
                        <?= $form->field($model, 'password')->input('password', [
                            'placeholder' => t('Пароль'),
                            'class' => 'form-control '
                        ])->label(false) ?>
                    </div>
                    <?= $form->field($model, 'rememberMe', ['template' => '
                        <div class="custom-control custom-checkbox">
                            {input}
                            <label class="custom-control-label" for="loginform-rememberme">' . $model->getAttributeLabel('rememberMe') . '</label>
                        </div>
                    '])->input('checkbox', [
                        'class' => 'custom-control-input',
                        'id' => 'loginform-rememberme'
                    ])->label(false) ?>

                    <div class="mt-30">
                        <?= Html::submitButton(t('Войти'), ['class' => 'btn btn-primary fs-15 py-5 px-35 mr-10']); ?>
                        <a class="btn btn-outline-secondary fs-15 py-5 px-25" href="<?= toRoute('/site/login-ecp') ?>" title="<?= t("Войти через электронная цифровая подпись") ?>"><?= t("Войти через ЭЦП") ?></a>
                    </div>
                    <?php \yii\bootstrap\ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</main>