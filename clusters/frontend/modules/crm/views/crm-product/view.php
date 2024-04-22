<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\crm\CrmProduct;

/* @var $this yii\web\View */
/* @var $model common\models\crm\CrmProduct */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('crm', 'Crm Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="crm-product-view">
    <?= $this->render("../layouts/_nav", [
//        'btn_title' => t("Добавить товар"),
//        'btn_url' => toRoute('/crm/crm-cargo-volumes/create')
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
//                            'code',
                            'title',
                            [
                                'attribute' => 'category_id',
                                'value' => function ($model){
                                    return $model->getCategoryTitle();
                                },
                                'filter' =>  false
//                            'filter' =>  \yii\helpers\ArrayHelper::map(
//                                \common\models\Company::find()
//                                    ->where(['company.id' => Yii::$app->user->identity->type==1?'ANY':Yii::$app->user->identity->company_id, 'status' => 1])
//                                    ->all(),
//                                'id',
//                                'name'
//                            )
                            ],
                            [
                                'attribute' => 'type_id',
                                'value' => function ($model){
                                    return Yii::$app->params['crm-product-types'][$model->type_id];
                                },
                                'filter' =>  Yii::$app->params['crm-product-types']
                            ],

                            'description',
                            [
                                'attribute' => 'company_id',
                                'value' => function ($model){
                                    return User::findOne($model->created_by)->company->name;
                                },
//                                'filter' =>  Yii::$app->params['crm-product-types']
                            ],

                            [
                                'attribute' => 'type_id',
                                'value' => function ($model){
                                    return Yii::$app->params['crm-product-types'][$model->type_id];
                                },
                                'filter' =>  Yii::$app->params['crm-product-types']
                            ],
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
                            ],

                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
