<?php

use common\models\crm\CrmProduct;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\crm\CrmCargoVolumesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('crm', 'Crm Cargo Volumes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crm-cargo-volumes-index">
    <?= $this->render("../layouts/_nav", [
        'btn_title' => t("Добавить Объемы грузов"),
        'btn_url' => toRoute('/crm/crm-cargo-volumes/create')
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
                                    return CrmProduct::getProductTitle($model->product_id);
                                },
                                'filter' =>  CrmProduct::getProducts()
                            ],

                            'size_loaded',
                            'size_delivered',
                            'size_remaining',
                            [
                                'attribute' => 'unit_id',
                                'value' => function ($model){
                                    return CrmProduct::getUnitTitle($model->unit_id);
                                },
                                'filter' =>  CrmProduct::getUnits()
                            ],
                            //                            'company_id',
                            'created_at:datetime',
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
