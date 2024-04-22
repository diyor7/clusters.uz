<?php

use common\models\Unit;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

?>
<div class="panel mb-4" style="padding: 10px; border: 3px solid #f8f8f8; background-color: #f6f6f6" data-tn_id="<?= $model->id ?>" data-category_id="<?= $model->category_id ?>">
    <div class="text-right">
        <a href="" class="close">X</a>
    </div>
    <p>
        <span class="number">#</span> — <?= $model->title ?>
    </p>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-25">
                <div class="form-group field-auction-category_id required">
                    <label class="control-label" for="auction-category_id">Количество</label>
                    <?= Html::input('number', 'AuctionTn[' . $model->id . '][quantity]', (isset($existModel) ? $existModel->quantity : ""), ['class' => 'form-control calc-qp', 'required' => true, 'min' => 0]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-25">
                <div class="form-group field-auction-category_id required">
                    <label class="control-label" for="auction-category_id">Единица измерения</label>
                    <?= Html::dropDownList('AuctionTn[' . $model->id . '][unit_id]', (isset($existModel) ? $existModel->unit_id : ""), ArrayHelper::map(Unit::find()->all(), 'id', 'title'), ['class' => 'form-control', 'required' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-25">
                <div class="form-group field-auction-category_id required">
                    <label class="control-label" for="auction-category_id">Стартовая сумма за единицу</label>
                    <?= Html::input('number', 'AuctionTn[' . $model->id . '][price]', (isset($existModel) ? $existModel->price : ""), ['class' => 'form-control calc-qp', 'required' => true, 'min' => 0]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-25">
                <div class="form-group field-auction-category_id required">
                    <label class="control-label" for="auction-category_id">Стартовая сумма</label>
                    <?= Html::input('number', 'AuctionTn[' . $model->id . '][price_sum]', (isset($existModel) ? $existModel->quantity * $existModel->price : ""), ['class' => 'form-control calc-r', 'readonly' => true, 'required' => true, 'min' => 0]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group mb-25">
                <div class="form-group field-auction-category_id required">
                    <label class="control-label" for="auction-category_id">Описание</label>
                    <?= Html::textarea('AuctionTn[' . $model->id . '][description]', (isset($existModel) ? $existModel->description : ""), ['class' => 'form-control', 'required' => true]) ?>
                </div>
            </div>
        </div>
    </div>
    <?= Html::input('hidden', 'AuctionTn[' . $model->id . '][tn_id]', $model->id, ['class' => 'form-control']) ?>
</div>