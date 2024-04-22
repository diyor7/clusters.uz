<?php
$this->title = t("Нормативная документация");
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
            <a href="https://lex.uz/docs/5476935" class="d-flex instructions align-items-center col-lg-12 mb-25" target="_blink">
                <div class="">
                    <div class="text-dark"><b><span>Постановление Президента Республики Узбекистан от 24 июнь 2021 года № ПП-5159</span></b></div>
                    <div class="gray-text"><span>«О ДОПОЛНИТЕЛЬНЫХ МЕРАХ ПО РАЗВИТИЮ ГОРНО-МЕТАЛЛУРГИЧЕСКОЙ ПРОМЫШЛЕННОСТИ И СМЕЖНЫХ ОТРАСЛЕЙ»</span></div>
                </div>
            </a>
            <a href="https://lex.uz/docs/5553516" class="d-flex instructions align-items-center col-lg-12 mb-25" target="_blink">
                <div class="">
                    <div class="text-dark"><b><span>Постановление Кабинета Министров Республики Узбекистан от 04 август 2021 года № ПКМ-498</span></b></div>
                    <div class="gray-text"><span>«ГЕОЛОГИЯ, КОН-МЕТАЛЛУРГИЯ ВА МИСНИ ҚАЙТА ИШЛАШ САНОАТИНИ УЗОҚ МУДДАТЛИ РИВОЖЛАНТИРИШ СТРАТЕГИЯСИНИ АМАЛГА ОШИРИШ ЧОРА-ТАДБИРЛАРИ ТЎҒРИСИДА»</span></div>
                </div>
            </a>
        </div>
    </div>
</div>