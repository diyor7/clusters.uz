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
<link rel="preload" href="/img/cert.svg" as="image">

<main>
    <div class="container-fluid my-80 pt-40 mh-50">
        <div class="row justify-content-md-center">
            <div class="col-6 col-xxl-4">
                <div class="shadow-lg rounded-lg bg-white p-30 fs-15 position-relative ">
                    <h4 class="title mt-0 mb-30 font-weight-bold"><?=t("Вход в систему")?></h4>
                    <?php $form =  \yii\bootstrap\ActiveForm::begin([
                        'action' => toRoute('/site/login'),
                        'method' => 'POST',
                        'options' => [
                            'class' => ''
                        ]
                    ]) ?>
                    <div class="form-group row mx-0">
                        <a class="py-5 px-0 h-auto col-2"><img src="/img/key.svg"></a>
                        <div class="px-15 d-inline-block col-10 align-middle">
                            <p class="form__dropdown-title"><?= t("Электронная цифровая подпись") ?></p>
                            <div class="dropdown">
                                <a class="btn btn-outline dropdown-toggle w-100 py-15 px-20 text-left fs-12 overflow-hidden" type="button" id="select-ecp" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?= t("Выберите") ?>
                                </a>
                                <div class="dropdown-menu p-15" aria-labelledby="select-ecp" style="will-change: transform;" id="ecp-keys">

                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="text-center mt-50" id="message">

                    </p>


                    <div class="mt-30">
                        <?= Html::button(t('Войти'), ['class' => 'btn btn-primary fs-15 py-5 px-35 mr-10', 'id' => "login-btn"]); ?>

                        <!-- <a class="btn btn-outline-secondary fs-15 py-5 px-25" href="<?= toRoute('/site/login') ?>" title="<?= t("Войти через телефон") ?>"><?= t("Войти через телефон") ?></a> -->
                    </div>
                    <?php \yii\bootstrap\ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</main>
