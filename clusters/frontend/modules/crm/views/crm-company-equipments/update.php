<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\crm\CrmCompanyEquipments */

$this->title = Yii::t('crm', 'Update Crm Company Equipments: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('crm', 'Crm Company Equipments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('crm', 'Update');
?>
<div class="crm-company-equipments-update">
    <div class="crm-company-equipments-index">
        <?= $this->render("../layouts/_nav", [
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
</div>
