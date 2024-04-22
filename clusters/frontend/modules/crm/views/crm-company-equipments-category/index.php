<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CrmCompanyEquipmentsCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('crm', 'Crm Company Equipments Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crm-company-equipments-category-index">

    <?= $this->render("../layouts/_nav", [
        'btn_title' => t("Добавить категория оборудования"),
        'btn_url' => toRoute('/crm/crm-company-equipments-category/create')
    ]) ?>
    <div class="new-bg-different py-30">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <?= $this->render("../layouts/_menu") ?>
                </div>
                <div class="col-md-9">
                    <div class="new-bg-different py-30">
                        <?php Pjax::begin(); ?>
                        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

//                                'id',
                                'title',
                                'description',
//                                'type_id',
                                'created_at:datetime',
                                //'created_by',

                                ['class' => 'yii\grid\ActionColumn','contentOptions' => ['class' => 'custom-action-buttons']],
                            ],
                        ]); ?>

                        <?php Pjax::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
