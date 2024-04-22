<?php

use common\models\Order;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = t("Редактировать заказ") . " №" . $order->id;

$this->params['breadcrumbs'][] = array(
    'label' => t("Личный кабинет"),
    'url' => toRoute('/cabinet')
);

$this->params['breadcrumbs'][] = array(
    'label' => t("Заказы"),
    'url' => toRoute('/cabinet/order')
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
                    <div class="form-group mb-25">
                        <?= $form->field($order, 'status')->dropDownList(Order::getGeneralStatuses(), [
                            'class' => 'form-control px-30'
                        ]) ?>
                    </div>

                    <div class="form-group mb-0">
                        <?= Html::submitButton($order->isNewRecord ? t('Добавить') : t("Редактировать"), ['class' => 'btn btn-success']); ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->registerJs('', \yii\web\View::POS_END); ?>