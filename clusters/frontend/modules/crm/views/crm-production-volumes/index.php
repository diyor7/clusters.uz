<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\crm\CrmProductionVolumesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('crm', 'Crm Production Volumes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crm-production-volumes-index">
    <?= $this->render("../layouts/_nav", [
        'btn_title' => t("Добавить информацию"),
        'btn_url' => toRoute('/crm/crm-production-volumes/create')
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
                            'date',
                            [
                                'attribute' => 'product_id',
                                'value' => function ($model){
                                    return \common\models\crm\CrmProduct::getProductTitle($model->product_id);
                                },
                                'filter' =>  \common\models\crm\CrmProduct::getProducts()
                            ],
                            'stock_volume',
                            'defective_volume',
                            'next_volume',
                            [
                                'attribute' => 'unit_id',
                                'value' => function ($model){
                                    return \common\models\crm\CrmProduct::getUnitTitle($model->unit_id);
                                },
                                'filter' =>  \common\models\crm\CrmProduct::getUnits()
                            ],
                            //'company_id',
                            'created_at:date',
                            //'created_by',
                            //'updated_at',
                            //'updated_by',

                            ['class' => 'yii\grid\ActionColumn','contentOptions' => ['class' => 'custom-action-buttons']],
                        ],
                    ]); ?>

                    <?php Pjax::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
