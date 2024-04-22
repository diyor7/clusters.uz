<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\crm\CrmCargoVolumes */

$this->title = Yii::t('crm', 'Create Crm Cargo Volumes');
$this->params['breadcrumbs'][] = ['label' => Yii::t('crm', 'Crm Cargo Volumes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crm-cargo-volumes-create">
    <?= $this->render("../layouts/_nav", [
//        'btn_title' => t("Добавить товар"),
//        'btn_url' => toRoute('/crm/crm-cargo-volumes/create')
    ]) ?>
    <div class="new-bg-different py-30">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <?= $this->render("../layouts/_menu") ?>
                </div>
                <div class="col-md-9">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>

            </div>
            </div>
        </div>
    </div>
</div>
