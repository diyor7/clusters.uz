<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\crm\CrmCompanyEquipmentsCategory */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('crm', 'Crm Company Equipments Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="crm-company-equipments-category-view">
    <?= $this->render("../layouts/_nav", [
    ]) ?>
    <div class="new-bg-different py-30">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <?= $this->render("../layouts/_menu") ?>
                </div>
                <div class="col-md-9">
                    <div class="new-bg-different py-30">
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
                                'title',
                                'description',
//                                'type_id',
                                'created_at:datetime',
                                [
                                    'attribute' => 'created_by',
                                    'value' => function ($model){
                                        return \common\models\crm\CrmProduct::getCreatedUserName($model->created_by);
                                    },
//                                'filter' =>  Yii::$app->params['crm-product-types']
                                ],

                            ],
                        ]) ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
