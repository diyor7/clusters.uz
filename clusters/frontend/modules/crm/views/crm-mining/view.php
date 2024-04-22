<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\crm\CrmMining */

$this->title = Yii::$app->params['mining-types'][$model->type];
$this->params['breadcrumbs'][] = ['label' => Yii::t('crm', 'Crm Minings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="crm-mining-view">
    <?= $this->render("../layouts/_nav", [
    ]) ?>
    <div class="new-bg-different py-30">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <?= $this->render("../layouts/_menu") ?>
                </div>
                <div class="col-md-9">
                    <p>
                        <?= Html::a(Yii::t('crm', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a(Yii::t('crm', 'Delete'), ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('crm', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'date',
                            [
                                'attribute' => 'type',
                                'value' => function ($model){
                                    return Yii::$app->params['mining-types'][$model->type];
                                },
//                                'filter' =>  Yii::$app->params['crm-product-types']
                            ],
                            [
                                'attribute' => 'product_id',
                                'value' => function ($model){
                                    return \common\models\crm\CrmProduct::getProductTitle($model->product_id);
                                },
//                                'filter' =>  Yii::$app->params['crm-product-types']
                            ],
                            'capacity',
                            [
                                'attribute' => 'unit_id',
                                'value' => function ($model){
                                    return \common\models\crm\CrmProduct::getUnitTitle($model->unit_id);
                                },
//                                'filter' =>  Yii::$app->params['crm-product-types']
                            ],
                            [
                                'attribute' => 'mine_id',
                                'value' => function ($model){
                                    return \common\models\crm\CrmMining::getMineTitle($model->mine_id);
                                },
//                                'filter' =>  Yii::$app->params['crm-product-types']
                            ],
                            'capacity_next',
                            [
                                'attribute' => 'capacity_next_unit_id',
                                'value' => function ($model){
                                    return \common\models\crm\CrmProduct::getUnitTitle($model->capacity_next_unit_id);
                                },
//                                'filter' =>  Yii::$app->params['crm-product-types']
                            ],
                            [
                                'attribute' => 'created_by',
                                'value' => function ($model){
                                    return \common\models\crm\CrmProduct::getCreatedUserName($model->created_by);
                                },
//                                'filter' =>  Yii::$app->params['crm-product-types']
                            ],

                            'updated_at:datetime',
                            [
                                'attribute' => 'updated_by',
                                'value' => function ($model){
                                    return \common\models\crm\CrmProduct::getCreatedUserName($model->updated_by);
                                },
//                                'filter' =>  Yii::$app->params['crm-product-types']
                            ],
//                            'co
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
