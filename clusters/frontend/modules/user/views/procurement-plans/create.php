<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProcurementPlan */

$this->title = t('Добавить план закупок');
$this->params['breadcrumbs'][] = ['label' => 'План закупок', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>