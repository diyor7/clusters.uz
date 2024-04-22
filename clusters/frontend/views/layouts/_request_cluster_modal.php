<?php

use common\models\Region;
use common\models\RequestCluster;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$model = new RequestCluster();
?>

<div class="modal" id="requestClusterModal">
    <div class="modal-dialog request-modal modal-lg modal-dialog-centered">
        <div class="modal-body bg-white">
            <div class="text-right">
                <a class="cursor-pointer" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="/img/modal-close.svg" alt="">
                </a>
            </div>
            <h2 style="color: #873F30"> <?= t("Заявление для участия в медном кластере") ?></h2>

            <?php $form = ActiveForm::begin([
                'method' => "POST",
                'action' => toRoute('/site/request-cluster')
            ]) ?>

            <?= $form->field($model, "tin")->widget(MaskedInput::class, [
                'mask' => '999999999',
            ]) ?>
            <?= $form->field($model, "name")->input('text') ?>
            <?= $form->field($model, "region_id")->dropDownList(ArrayHelper::map(Region::find()->where(['type' => Region::TYPE_GENERAL])->all(), 'id', 'title')) ?>
            <?= $form->field($model, "address")->input('text') ?>
            <?= $form->field($model, "phone")->widget(MaskedInput::className(), [
                'mask' => '\+\9\9\8999999999',
            ]) ?>
            <?= $form->field($model, "email")->input('email') ?>
            <?= $form->field($model, "activity")->input('text') ?>
            <?= $form->field($model, "products")->input('text') ?>
            <?= $form->field($model, "investment_size")->input('text') ?>
            <?= $form->field($model, "workplaces")->input('number') ?>
            <?= $form->field($model, "production_capacity")->input('text') ?>

            <?= Html::submitButton(t("Отправить"), ['class' => "btn btn-success"]) ?>

            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>