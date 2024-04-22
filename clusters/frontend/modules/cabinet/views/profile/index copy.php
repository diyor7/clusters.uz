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
                    <div class="form-group">
                        <label class="fw-semi-bold" for="inn"><?= t("Ф.И.О.") ?></label>
                        <?= $user->full_name ?>
                    </div>
                    <div class="form-group">
                        <label class="fw-semi-bold"><?= t("Логин") ?></label>
                        <?= $user->username ?>
                    </div>
                    <div class="form-group">
                        <label class="fw-semi-bold"><?= t("Почта") ?></label>
                        <?= $user->email ?>
                    </div>
                    <div class="form-group">
                        <label class="fw-semi-bold"><?= t("Адрес") ?></label>
                        <?= $user->address ? $user->address : t("(не указано)") ?>
                    </div>

                    <div class="text-right">
                        <a href="<?=toRoute(['update'])?>" class="btn btn-success"><?= t("Изменить") ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->registerJs('', \yii\web\View::POS_END); ?>