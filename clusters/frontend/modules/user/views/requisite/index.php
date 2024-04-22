<?php

use common\models\Company;
use common\models\Region;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\widgets\MaskedInput;

$this->title = t("Реквизиты");

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
                    <?php $form =  \yii\bootstrap\ActiveForm::begin([
                        'method' => 'POST',

                    ]) ?>
                    <div class="form-group">
                        <?= $form->field($model, 'name')->input('text', [
                            'class' => 'form-control py-20 px-30'
                        ]) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'type')->dropDownList(Company::getTypes(), [
                            'class' => 'form-control px-30',
                            'disabled' => true
                        ]) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'tin')->input('text', [
                            'class' => 'form-control py-20 px-30',
                            'disabled' => true
                        ]) ?>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <?= $form->field($account, 'account')->widget(MaskedInput::class, [
                                    'mask' => '99999999999999999999',
                                    'options' => [
                                        'class' => 'form-control py-20 px-30'
                                    ]
                                ]) ?>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <?= $form->field($account, 'mfo')->widget(MaskedInput::class, [
                                    'mask' => '99999',
                                    'options' => [
                                        'class' => 'form-control py-20 px-30'
                                    ]
                                ]) ?>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-group">
                                <?= $form->field($model, 'employees')->input('text', [
                                    'class' => 'form-control py-20 px-30'
                                ]) ?>
                            </div> -->

                    <div class="form-group">
                        <?= $form->field($model, 'region_id')->dropDownList(Region::getTree(), [
                            'class' => 'form-control px-30',
                        ]) ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                            'mask' => '\+\9\9\8999999999',
                            'options' => [
                                'class' => 'form-control py-20 px-30'
                            ]
                        ]) ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'email')->input('email', [
                            'class' => 'form-control py-20 px-30'
                        ]) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'site')->input('text', [
                            'class' => 'form-control py-20 px-30'
                        ]) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'address')->textarea([
                            'class' => 'form-control py-20 px-30',
                            'rows' => 4
                        ]) ?>
                    </div>
                    <div class="form-group mb-0">
                        <?= Html::submitButton($model->isNewRecord ? t('Добавить') : t("Редактировать"), ['class' => 'btn btn-success']); ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->registerJs('', \yii\web\View::POS_END); ?>