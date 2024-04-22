<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\crm\CrmMiningSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('crm', 'Crm Minings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crm-mining-index">
    <?= $this->render("../layouts/_nav", [
        'btn_title' => t("Добавить Добыча ископаемых"),
        'btn_url' => toRoute('/crm/crm-mining/create')
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
                                'attribute' => 'type',
                                'value' => function ($model){
                                    return Yii::$app->params['mining-types'][$model->type];
                                },
                                'filter' =>  Yii::$app->params['mining-types']
                            ],
//                            'size',
                            [
                                'attribute' => 'product_id',
                                'value' => function ($model){
                                    return \common\models\crm\CrmProduct::getProductTitle($model->product_id);
                                },
                                'filter' =>  \common\models\crm\CrmProduct::getProducts()
                            ],
                            'capacity',
                            [
                                'attribute' => 'unit_id',
                                'value' => function ($model){
                                    return \common\models\crm\CrmProduct::getUnitTitle($model->unit_id);
                                },
                                'filter' =>  \common\models\crm\CrmProduct::getUnits()
                            ],
                            [
                                'attribute' => 'mine_id',
                                'value' => function ($model){
                                    return \common\models\crm\CrmMining::getMineTitle($model->mine_id);
                                },
                                'filter' =>  \common\models\crm\CrmMining::getMines()
                            ],
//                            'capacity_next',
//                            [
//                                'attribute' => 'capacity_next_unit_id',
//                                'value' => function ($model){
//                                    return \common\models\crm\CrmProduct::getUnitTitle($model->capacity_next_unit_id);
//                                },
//                                'filter' =>  \common\models\crm\CrmProduct::getUnits()
//                            ],

                            ['class' => 'yii\grid\ActionColumn','contentOptions' => ['class' => 'custom-action-buttons']],
                        ],
                    ]); ?>

                    <?php Pjax::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
