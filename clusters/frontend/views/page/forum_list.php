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

$this->title = Yii::t('main', 'Конференция');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container my-4">

<div class="row">

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <h1>
                <?= Yii::t('main', 'Конференция') ?>
            </h1>
        </div>

        <div class="pull-right">
            <a href="<?= toRoute(['/page/export']) ?>" class="btn btn-success">Export Excel</a>
        </div>
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
                'id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'organization',
                'occupation',
                'panel',
                [
                    'attribute' => 'who_is',
                    'value' => function ($model) {
                        return \common\models\Forum::getTypeWhoIs($model->who_is);
                    },
                ],
                'theme',
                'country',
            ],
        ]); ?>
    </div>

</div>
</div>
