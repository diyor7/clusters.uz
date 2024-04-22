<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProcurementPlan */

$this->title = 'Изменить: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'План закупок', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
