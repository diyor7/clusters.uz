<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\crm\CrmEmployeeActivityTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('crm', 'Crm Employee Activity Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crm-employee-activity-type-index">
    <?= $this->render("../layouts/_nav", [
        'btn_title' => t("Добавить вид деятельности сотрудника"),
        'btn_url' => toRoute(['/crm/crm-employee-activity-type/create'])
    ]) ?>
    <div class="new-bg-different py-30">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <?= $this->render("../layouts/_menu") ?>
                </div>
                <div class="col-md-9">
                    <?php Pjax::begin(); ?>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

//                            'id',
                            'title',
                            'description',
//                            'company_id',

                            ['class' => 'yii\grid\ActionColumn','contentOptions' => ['class' => 'custom-action-buttons']],

                        ],
                    ]); ?>

                    <?php Pjax::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
