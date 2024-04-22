<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\CategorySearch $searchModel
 */

$this->title = Yii::t('main', 'Список приложений');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container my-4">

    <div class="row">

        <div class="clearfix crud-navigation">
            <div class="pull-left">
                <h1>
                    <?= Yii::t('main', 'Список приложений') ?>
                </h1>
            </div>

            <!-- <div class="pull-right">
                <a href="<?= toRoute(['/page/export']) ?>" class="btn btn-success">Export Excel</a>
            </div> -->
        </div>

        <hr />

        <div class="table-responsive">
            <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'pager' => [
                'class' => yii\widgets\LinkPager::className(),
                'firstPageLabel' => 'First',
                'lastPageLabel' => 'Last',
            ],
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
            'headerRowOptions' => ['class' => 'x'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'company_name',
                [
                    'attribute' => 'investment_order',
                    'format' => 'raw',
                    'value' => function($m){
                        return Html::a($m->investment_order, siteUrl() . 'uploads/texnopark/' . $m->investment_order, ['target' => '_blank']);
                    }
                ],
                [
                    'attribute' => 'owner_identity_doc',
                    'format' => 'raw',
                    'value' => function($m){
                        return Html::a($m->owner_identity_doc, siteUrl() . 'uploads/texnopark/' . $m->owner_identity_doc, ['target' => '_blank']);
                    }
                ],
                [
                    'attribute' => 'certificate',
                    'format' => 'raw',
                    'value' => function($m){
                        return Html::a($m->certificate, siteUrl() . 'uploads/texnopark/' . $m->certificate, ['target' => '_blank']);
                    }
                ],
                [
                    'attribute' => 'company_charter',
                    'format' => 'raw',
                    'value' => function($m){
                        return Html::a($m->company_charter, siteUrl() . 'uploads/texnopark/' . $m->company_charter, ['target' => '_blank']);
                    }
                ],
                [
                    'attribute' => 'business_plan',
                    'format' => 'raw',
                    'value' => function($m){
                        return Html::a($m->business_plan, siteUrl() . 'uploads/texnopark/' . $m->business_plan, ['target' => '_blank']);
                    }
                ],
                [
                    'attribute' => 'balance_sheet',
                    'format' => 'raw',
                    'value' => function($m){
                        return Html::a($m->balance_sheet, siteUrl() . 'uploads/texnopark/' . $m->balance_sheet, ['target' => '_blank']);
                    }
                ],
                [
                    'attribute' => 'investment_guarantee_letter',
                    'format' => 'raw',
                    'value' => function($m){
                        return Html::a($m->investment_guarantee_letter, siteUrl() . 'uploads/texnopark/' . $m->investment_guarantee_letter, ['target' => '_blank']);
                    }
                ],
            ],
        ]); ?>
        </div>

    </div>
</div>