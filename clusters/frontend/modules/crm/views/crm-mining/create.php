<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\crm\CrmMining */

$this->title = Yii::t('crm', 'Create Crm Mining');
$this->params['breadcrumbs'][] = ['label' => Yii::t('crm', 'Crm Minings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crm-mining-create">
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
