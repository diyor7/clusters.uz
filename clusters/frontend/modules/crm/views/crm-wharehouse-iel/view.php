<?php

use common\models\crm\CrmProduct;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\crm\CrmWharehouseIel */

$this->title = Yii::$app->params['crm-product-types'][$model->prduct_type_id];
$this->params['breadcrumbs'][] = ['label' => Yii::t('crm', 'Crm Wharehouse Iels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="crm-wharehouse-iel-view">
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
                            [
                                'attribute' => 'prduct_type_id',
                                'value' => function ($model){
                                    return Yii::$app->params['crm-product-types'][$model->prduct_type_id];
                                },
//                                'filter' =>  Yii::$app->params['crm-product-types']
                            ],
//                            'prduct_type_id',
                            [
                                'attribute' => 'product_id',
                                'value' => function ($model){
                                    return CrmProduct::getProductTitle($model->product_id);
                                },
//                                'filter' =>  Yii::$app->params['crm-product-types']
                            ],

                            'balance_from',
                            'balance_out',
                            'balance_in',
                            'balance_left',
                            [
                                'attribute' => 'product_unit_id',
                                'value' => function ($model){
                                    return CrmProduct::getUnitTitle($model->product_unit_id);
                                },
//                                'filter' =>  Yii::$app->params['crm-product-types']
                            ],//                            'company_id',
                            'created_at:datetime',
                            [
                                'attribute' => 'created_by',
                                'value' => function ($model){
                                    return CrmProduct::getCreatedUserName($model->created_by);
                                },
//                                'filter' =>  Yii::$app->params['crm-product-types']
                            ],

                            'updated_at:datetime',
                            [
                                'attribute' => 'updated_by',
                                'value' => function ($model){
                                    return CrmProduct::getCreatedUserName($model->updated_by);
                                },
//                                'filter' =>  Yii::$app->params['crm-product-types']
                            ],                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
