<?php

use common\models\Company;
use common\models\Region;
use yii\bootstrap\Html;
use yii\widgets\MaskedInput;

$this->title = t("Подтвердить ИНН");

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
                <div class="cabinet__content" id="fullscreenme">
                    <h2 class="font-weight-bold font-family-monsterrat fs-24 mb-10"><?= $this->title ?></h2>
                    <div class="product-single-tabs clearfix mt-5">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="tab-content px-30 pt-15 mt-45 gray-bg pb-15">
                                    <?php $form =  \yii\bootstrap\ActiveForm::begin([
                                        'method' => 'get',
                                        'options' => [
                                            'class' => 'form'
                                        ]
                                    ]) ?>

                                    <div class="form-group mb-25">
                                        <?= MaskedInput::widget([
                                            'mask' => '999999999',
                                            'name' => "tin",
                                            'options' => [
                                                'class' => 'form-control py-20 px-30',
                                                'placeholder' => t("Введите ваш инн")
                                            ]
                                        ]) ?>
                                    </div>

                                    <div class="form-group mb-0">
                                        <?= Html::submitButton(t("Подтвердить"), ['class' => 'btn btn-success']); ?>
                                    </div>

                                </div>
                                <?php \yii\bootstrap\ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->registerJs('', \yii\web\View::POS_END); ?>