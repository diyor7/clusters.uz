<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = getTranslate('Перейти в кабинет');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid my-60 mh-50">
    <div class="row justify-content-md-center pt-30">
        <div class="col-6 col-xxl-4">
            <div class="shadow-lg rounded-lg bg-white p-30 fs-15 position-relative ">
                <h4 class="text-center"><?= t("Выберите кабинет") ?></h4>
                <div class="row mt-50">
                    <div class="col-md-12 mb-20">
                        <a href="<?= toRoute('/user') ?>" class="btn btn-primary w-100 py-10"><?= t("Заказчик") ?></a>
                    </div>
                    <div class="col-md-12 mb-20">
                        <a href="<?= toRoute('/cabinet') ?>" class="btn btn-primary w-100 py-10"><?= t("Поставщик") ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>