<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\crm\CrmCompanyEquipmentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('crm', 'Crm Company Equipments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crm-company-equipments-index">
    <?= $this->render("../layouts/_nav", [
        'btn_title' => t("Добавить оборудования"),
        'btn_url' => toRoute('/crm/crm-company-equipments/create')
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
//                            'code',
                            [
                                'attribute' => 'category_id',
                                'value' => function ($model){
                                    return $model->categoryTitle;
                                },
                                'filter' =>  \common\models\crm\CrmCompanyEquipments::getCategories()
                            ],
//                            'type_id',
                            'title',
                            //'description',
                            'parametres',
                            'equipment_count',
                            'created_at:datetime',
                            //'created_by',
                            //'updated_at',
                            //'updated_by',
                            //'company_id',

                            ['class' => 'yii\grid\ActionColumn','contentOptions' => ['class' => 'custom-action-buttons']],
                        ],
                    ]); ?>

                    <?php Pjax::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
