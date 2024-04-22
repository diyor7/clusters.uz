<?php
/**
 * @var common\models\Forum $model
 * @var yii\widgets\ActiveForm $form
 */
$this->title = t("Участие в конференции");
?>

<div class="bg-white">
    <div class="container py-30">
        <div class="d-flex align-items-start mb-25">
            <div>
                <h1 class="new-title-4 mb-0 pt-2">
                    <?= $this->title ?>
                </h1>
            </div>
        </div>

        <div class="new-breadcrumbs d-flex align-items-center">
            <a href="<?= toRoute('/') ?>"><?=t("Главная")?></a>
            <span></span>
            <p><?= $this->title ?></p>
        </div>
    </div>
</div>
<div class="new-bg-different">
    <div class="container py-40">
        <div class="row">

            <div class="col-md-6 m-auto">
                <?php $form = \yii\widgets\ActiveForm::begin();?>

                <?= $form->field($model, 'who_is')->dropDownList(\common\models\Forum::getTypeWhoIs()) ?>
                <?= $form->field($model, 'panel')->dropDownList([
                        t("1.	Геологоразведка и классификация JORC.") =>  t("1.	Геологоразведка и классификация JORC."),
                        t("2.	Добыча, производство и технология.") =>     t("2.	Добыча, производство и технология."),
                        t("3.	Экономика на добыче полезных ископаемых и оптимизация эксплуатационных расходов;") =>   t("3.	Экономика на добыче полезных ископаемых и оптимизация эксплуатационных расходов;"),
                        t("4.	Окружающая среда, социальная сфера и управление (ESG);") =>     t("4.	Окружающая среда, социальная сфера и управление (ESG);"),
                ]) ?>

                <div class="form-group mb-10">
                    <label for="a-name5"><?= t("Страна") ?>:</label>
                    <select name="Forum[country]" class="confirensiya-ajax-custom w-100" >
                        <option value=""><?=t("Выберите")?></option>
                    </select>
                </div>

                <?= $form->field($model, 'organization')->textInput() ?>
                <?= $form->field($model, 'occupation')->textInput() ?>

                <?= $form->field($model, 'theme')->textInput() ?>

                <?= $form->field($model, 'first_name')->textInput() ?>
                <?= $form->field($model, 'last_name')->textInput() ?>
                <?= $form->field($model, 'email')->textInput() ?>
                <?= $form->field($model, 'phone')->textInput() ?>

                <?php echo $form->errorSummary($model); ?>

                <?= \yii\helpers\Html::submitButton(
                    t('Добавить'),
                    [
                        'class' => 'btn btn-success'
                    ]
                );
                ?>
                <a href="<?=toRoute(['/page/conference'])?>" class="btn btn-danger"><?=t("Отменён")?></a>

                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>

<?php $this->registerJs('


function checkDelivery (){
    if ($("#forum-who_is").val() == 1){
        $(".field-forum-theme").fadeOut(200);
    } else {
        $(".field-forum-theme").fadeIn(200);
    }
}

checkDelivery ();

$("#forum-who_is").change(function (){
    checkDelivery ();
});


',3) ?>