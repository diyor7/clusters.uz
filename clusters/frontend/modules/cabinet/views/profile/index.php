<?php

use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = t("Личные данные");

$this->params['breadcrumbs'][] = array(
    'label' => t("Личный кабинет"),
    'url' => toRoute('/cabinet')
);
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render("../layouts/_nav") ?>

<div class="new-bg-different py-30">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?= $this->render("../layouts/_menu") ?>
            </div>
            <div class="col-md-9">
                <div class="shadow rounded bg-white p-20 fs-15">
                    <?php $form = ActiveForm::begin() ?>
                    <p>
                        <?=t("* - поля обязательные для заполнения")?>
                    </p>
                    <div class="form-group">
                        <label class="fw-semi-bold" for="inn"><?= t("Ф.И.О.") ?>*</label>
                        <?= $form->field($model, 'full_name')->textInput(['class' => 'form-control'])->label(false) ?>
                    </div>
                    <div class="form-group">
                        <label class="fw-semi-bold"><?= t("Номер телефона") ?>*</label>
                        <?= $form->field($model, 'username')->widget(MaskedInput::className(), [
                            'mask' => '\+\9\9\8999999999',
                            'options' => [
                                'placeholder' => $model->getAttributeLabel('username'),
                                'class' => 'form-control',
                                'readonly' => true
                            ]
                        ])->label(false) ?>
                    </div>
                    <div class="form-group">
                        <label class="fw-semi-bold"><?= t("Электронная почта") ?>*</label>
                        <?= $form->field($model, 'email')->label(false) ?>
                    </div>
                    <!-- <div class="form-group">
                        <label class="fw-semi-bold"><?= t("Адрес") ?></label>
                        <?= $form->field($model, 'address')->label(false) ?>
                    </div> -->

                    <div class="form-group">
                        <label class="fw-semi-bold"><?= t("Новый пароль (если хотите изменить)") ?></label>
                        <?= $form->field($model, 'password')->input("password")->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label class="fw-semi-bold"><?= t("Повторите новый пароль") ?></label>
                        <?= $form->field($model, 'confirm_password')->input("password")->label(false) ?>
                    </div>

                    <div class="text-right">
                        <button class="btn btn-success"><?= t("Изменить") ?></button>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->registerJs('', \yii\web\View::POS_END); ?>