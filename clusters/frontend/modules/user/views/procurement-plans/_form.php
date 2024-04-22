<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\ProcurementPlan */
/* @var $form yii\widgets\ActiveForm */
?>
<?= $this->render("../layouts/_nav", [
    'breadcrumb_title' => t("План закупок"),
    'breadcrumb_url' => toRoute('/user/procurement-plans')
]) ?>

<div class="new-bg-different py-30">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?= $this->render("../layouts/_menu") ?>
            </div>
            <div class="col-md-9">
                <div class="procurement-plan-form shadow rounded bg-white p-20 fs-15">

                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col">
                            <?= $form->field($model, 'year')->textInput(['value' => date('Y')]) ?>
                        </div>
                        <div class="col">
                            <?= $form->field($model, 'kvartal')->dropDownList(\common\models\ProcurementPlan::kvartals(), ['prompt' => 'Выберите квартал или месяц']) ?>
                        </div>
                    </div>

                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                    <?php $category = \common\models\Category::findOne(['id' => $model->category_id]); ?>


                    <?= $form->field($model, 'category_id')->dropDownList($category ? [$category->id => $category->title] : [], ['class' => 'category-ajax form-control']);
                    ?>

                    <?= $form->field($model, 'functionality')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'technicality')->textarea(['rows' => 6]) ?>

                    <div class="row">
                        <div class="col">
                            <?= $form->field($model, 'unit_val')->textInput() ?>
                        </div>
                        <div class="col">
                            <?= $form->field($model, 'unit_id')
                                ->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Unit::find()->all(), 'id', 'title'), ['prompt' => 'Выберите ед.измерения']) ?>
                        </div>
                    </div>

                    <?php if ($model->filename) : ?>
                        <a href="<?= siteUrl() . 'uploads/plan/' . $model->filename ?>" class="d-inline-block mb-10" target="_blank"><?= t("Ранее загруженный файл") ?></a>
                    <?php endif ?>

                    <?= $form->field($model, 'file')->fileInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton(t('Сохранить'), ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs('
    
', 3)
?>