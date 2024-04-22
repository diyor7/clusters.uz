<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\crm\CrmProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('crm', 'Crm Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crm-product-index">
    <?= $this->render("../layouts/_nav", [
        'btn_title' => t("Добавить товар"),
        'btn_url' => toRoute('/crm/crm-product/create')
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

//                        'id',
//                        'code',
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

                        //'description',
//                        'company_id',
                        'created_at:datetime',
                        [
                            'attribute' => 'created_by',
                            'value' => function ($model){
                                return \common\models\crm\CrmProduct::getCreatedUserName($model->created_by);
                            },
//                                'filter' =>  Yii::$app->params['crm-product-types']
                        ],

//                        'updated_at:datetime',
//                        'updated_by',

                        ['class' => 'yii\grid\ActionColumn','contentOptions' => ['class' => 'custom-action-buttons']],
                    ],
                ]); ?>

                <?php Pjax::end(); ?>
                </div>

            </div>
        </div>
    </div>
</div>