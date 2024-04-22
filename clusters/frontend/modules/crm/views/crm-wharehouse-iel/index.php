<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\crm\CrmWharehouseIelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('crm', 'Crm Wharehouse Iels');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crm-wharehouse-iel-index">
    <?= $this->render("../layouts/_nav", [
        'btn_title' => t("Добавить информацию"),
        'btn_url' => toRoute('/crm/crm-wharehouse-iel/create')
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

                            [
                                'attribute' => 'prduct_type_id',
                                'value' => function ($model){
                                    return Yii::$app->params['crm-product-types'][$model->prduct_type_id];
                                },
                                'filter' =>  Yii::$app->params['crm-product-types']
                            ],
                            [
                                'attribute' => 'product_id',
                                'value' => function ($model){
                                    return \common\models\crm\CrmProduct::getProductTitle($model->product_id);
                                },
                                'filter' =>  \common\models\crm\CrmProduct::getProducts()
                            ],

                            'balance_from',
                            'balance_out',
                            'balance_in',
                            'balance_left',
                            [
                                'attribute' => 'product_unit_id',
                                'value' => function ($model){
                                    return \common\models\crm\CrmProduct::getUnitTitle($model->product_unit_id);
                                },
                                'filter' =>  \common\models\crm\CrmProduct::getUnits()
                            ],
                            //'company_id',
                            //'created_at',
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
