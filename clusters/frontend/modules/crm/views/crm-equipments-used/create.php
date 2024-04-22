<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\crm\CrmEquipmentsUsed */

$this->title = Yii::t('crm', 'Create Crm Equipments Used');
$this->params['breadcrumbs'][] = ['label' => Yii::t('crm', 'Crm Equipments Useds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crm-equipments-used-create">
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
