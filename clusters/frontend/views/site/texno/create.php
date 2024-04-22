<?php
/**
 * @var common\models\Forum $model
 * @var yii\widgets\ActiveForm $form
 */
$this->title = t("Заявление на прием в технопарк");
?>
<style>
*,
*:before,
*:after {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

div.custom-file {
    margin: 0;
    padding: 2rem 1.5rem;
    font: 1rem/1.5 "PT Sans", Arial, sans-serif;
    color: #5a5a5a;
}
</style>
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

            <div class="col-md-8 m-auto panel">
                <div class="rounded bg-white p-20 fs-15">

                    <p>
                        <a href="#!" data-toggle="modal" data-target="#requestClusterModalTech" class="btn btn-success"
                            title="Заявление для участия в медном кластере">
                            <?=t("Требования к проекту")?>
                        </a>
                        <?=t("Пожалуйста, убедитесь, что вы прочитали требования к проектам")?>
                    </p>

                    <?php
                     $form = \yii\widgets\ActiveForm::begin([
                        'action' => toRoute(['texnopark-application-save']),
                        'method' => 'post', 
                        'options' => ['enctype' => 'multipart/form-data']
                    ]);
                    ?>

                    <?= $form->field($model, 'company_name')->textInput(['placeholder' => t("Введите название компании")]) ?>



                    <a href="/Илова.docx" class=""><?=t("Скачат анкету")?> <i
                            class="fa fa-download"></i> </a>

                    <div class="mb-4">
                        <label for="texnoparkapplication-investment_order"
                            class="form-label"><?=t("Инвестиционное заявление (.pdf)")?></label>
                        <input class="form-control" type="file" id="texnoparkapplication-investment_order"
                            name="TexnoparkApplication[investment_order_file]" accept="application/pdf">
                        <div class="help-block"></div>
                    </div>

                    <p class="" style="color:#00A271"><b><?=t("Приложения к заявке")?></b></p>

                    <div class="mb-4">
                        <label for="texnoparkapplication-owner_identity_doc"
                            class="form-label"><?=t("Удостоверение личности директора (.pdf)")?></label>
                        <input class="form-control" type="file" id="texnoparkapplication-owner_identity_doc"
                            name="TexnoparkApplication[owner_identity_doc_file]" accept="application/pdf">
                        <div class="help-block"></div>
                    </div>
                    <div class="mb-4">
                        <label for="texnoparkapplication-certificate" class="form-label"><?=t("Сертификат (.pdf)")?></label>
                        <input class="form-control" type="file" id="texnoparkapplication-certificate"
                            name="TexnoparkApplication[certificate_file]">
                        <div class="help-block"></div>
                    </div>
                    <div class="mb-4">
                        <label for="texnoparkapplication-company_charter"
                            class="form-label"><?=t("Устав компании (.pdf)")?></label>
                        <input class="form-control" type="file" id="texnoparkapplication-company_charter"
                            name="TexnoparkApplication[company_charter_file]" accept="application/pdf">
                        <div class="help-block"></div>
                    </div>
                    <div class="mb-4">
                        <label for="texnoparkapplication-business_plan"
                            class="form-label"><?=t("ТЭО или Бизнес план (.pdf)")?></label>
                        <input class="form-control" type="file" id="texnoparkapplication-business_plan"
                            name="TexnoparkApplication[business_plan_file]" accept="application/pdf">
                        <div class="help-block"></div>
                    </div>
                    <div class="mb-4">
                        <label for="texnoparkapplication-balance_sheet"
                            class="form-label"><?=t("Финансовые резултаты за 2022 (.pdf)")?></label>
                        <input class="form-control" type="file" id="texnoparkapplication-balance_sheet"
                            name="TexnoparkApplication[balance_sheet_file]" accept="application/pdf">
                        <div class="help-block"></div>
                    </div>
                    <div class="mb-4">
                        <label for="texnoparkapplication-investment_guarantee_letter"
                            class="form-label"><?=t("Гарантийное письмо инвестиции (.pdf)")?></label>
                        <input class="form-control" type="file" id="texnoparkapplication-investment_guarantee_letter"
                            name="TexnoparkApplication[investment_guarantee_letter_file]" accept="application/pdf">
                        <div class="help-block"></div>
                    </div>

                    <?php //echo $form->errorSummary($model); ?>

                    <?= \yii\helpers\Html::submitButton(
                            t('Добавить'),
                            [
                                'class' => 'btn btn-primary'
                            ]
                        );
                        ?>
                    <!-- <a href="<?=toRoute(['/page/conference'])?>" class="btn btn-danger"><?=t("Отменён")?></a> -->
                    <!-- </form> -->
                    <?php \yii\widgets\ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="requestClusterModalTech">
    <div class="modal-dialog request-modal modal-lg modal-dialog-centered">
        <div class="modal-body bg-white">

            <div class="bg-white">
                <div class="container py-30">
                    <div class="d-flex align-items-around mb-25" style="justify-content: space-between;">
                        <div>
                            <h1 class="new-title-4 mb-0 pt-2">
                                <?= t("Бизнес-режа тайёрлаш зарур талаблари") ?>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="new-bg-different">
                <div class="container py-40">

                    
                    <ul style="list-style-type: decimal;">
                        <li>инвестицияларнинг ҳажмлари, турлари ва муддатлари, молиялаштириш манбалари ва кредит олишда
                            кутилаётган гаров;</li>
                        <li>инвестиция лойиҳасининг молиявий-иқтисодий ҳисоб-китоблари ва иқтисодий самарадорлиги
                            кўрсаткичлари;</li>
                        <li>таклиф этилаётган инвестициялар ҳажми, тури ва муддатлари, молиялаштириш манбалари.</li>
                        <li>юридик шахс (кейинги ўринларда буюртманома берувчи) ёки унинг таъсисчилари ташкил
                            этилганлиги, уларнинг тегишли соҳадаги ва шунга ўхшаш инвестиция лойиҳасини амалга
                            оширишдаги тажрибаси тўғрисидаги маълумотлар;</li>
                        <li>кадрларни ишга олиш манбалари кўрсатилган ҳолда яратилган иш ўринлари сони;</li>
                        <li>ишлаб чиқариш режалаштирилган маҳсулотларнинг номи, хусусиятлари ва ҳажмлари;</li>
                        <li>ички ва ташқи бозорларга етказиб бериш ҳажмини кўрсатган ҳолда маҳсулотларнинг тахминий
                            баҳолари ва бозорлари;</li>
                        <li>ишлаб чиқариш режалаштирилган маҳсулотларнинг ички ва ташқи бозорларини маркетинг
                            тадқиқотлари;</li>
                        <li>инвестиция лойиҳасини амалга ошириш даврида маҳаллий ва импорт қилинадиган материаллар,
                            бутловчи қисмлар алоҳида кўрсатилган ҳолда хомашё базаси ва кафолатланган хом ашё ва
                            материаллар билан таъминлаш имконияти мавжудлиги;</li>
                        <li>ишлаб чиқаришни маҳаллийлаштириш даражаси ва якуний маҳсулотнинг товар позициясининг
                            дастлабки 4та рақамдан бири даражасида Ўзбекистон Республикаси ташқи иқктисодий фаолият
                            товар номенклатураси кодига мувофиқ хом ашё ўзгариши ҳисоб-китоблари (ТН ВЭД 2017 версияси
                            бўйича код);</li>
                        <li>ишлаб чиқариш учун зарур бўлган ресурслар ва тайёр маҳсулотларни логистика ва ташиш;</li>
                        <li>инвестиция лойиҳасини амалга ошириш ва ишлаб чиқаришнинг барқарор ишлаши учун
                            муҳандислик-коммуникация воситаларининг (электр энергияси, газ, ичимлик ва саноат суви,
                            канализация, йўллар) зарур ҳажмлари ва параметрлари;</li>
                        <li>газлар, қаттиқ ва суюқ чиқиндиларнинг турлари ва ҳажмини кўрсатувчи саноат чиқиндиларининг
                            мавжудлиги;</li>
                        <li>ишлаб чиқаришни оқилона жойлаштириш учун эркин иқтисодий зона ҳудудидаги талаб қилинадиган
                            майдоннинг ҳажми;</li>
                        <li>асосий ишлаб чиқариш цехи, асбоб-ускуналар ва ишлаб чиқариш линияси, маъмурий бино,
                            омборхона ва бошқа ёрдамчи биноларнинг жойлашишини кўрсатувчи ишлаб чиқариш жойининг
                            дастлабки схемаси;</li>
                        <li>технологик асбоб-ускуналар, ишлаб чиқарувчилар, мамлакатларга етказиб берувчилари рўйхати
                            билан таклиф этилаётган ишлаб чиқариш технологиясининг тавсифи (экологик талабларни ҳисобга
                            олган ҳолда);</li>
                        <li>ишлаб чиқаришда фойдаланиш учун мўлжалланган технологик асбоб-ускуналарнинг
                            характеристикалари, шунингдек, халқаро стандартларга жавоб берадиган инвестиция лойиҳасида
                            фойдаланиладиган бошқарув тизими;</li>
                        <li>ишлаб чиқарилиши режалаштирилган маҳсулотларнинг қўшилган қиймат кўрсатилган жадвали</li>
                    </ul>


                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->registerJs('


// function checkDelivery (){
//     if ($("#forum-who_is").val() == 1){
//         $(".field-forum-theme").fadeOut(200);
//     } else {
//         $(".field-forum-theme").fadeIn(200);
//     }
// }

// checkDelivery ();

// $("#forum-who_is").change(function (){
//     checkDelivery ();
// });


',3) ?>