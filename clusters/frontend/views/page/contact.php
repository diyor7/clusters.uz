<?php
$this->title = t("Контакты");
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
            <div class="col-md-5">
                <div class="d-flex instructions align-items-center mb-25">
                    <div class="">
                        <div class="text-dark"><b><span><?= t("ИНН") ?>:</span></b></div>
                        <div class="gray-text"><span>308792441</span></div>
                    </div>
                </div>
                <div class="d-flex instructions align-items-center mb-25">
                    <div class="">
                        <div class="text-dark"><b><span><?= t("МФО") ?>:</span></b></div>
                        <div class="gray-text"><span>00419</span></div>
                    </div>
                </div>
                <div class="d-flex instructions align-items-center mb-25">
                    <div class="">
                        <div class="text-dark"><b><span><?= t("Р/с") ?>:</span></b></div>
                        <div class="gray-text"><span>20210000305520414001</span></div>
                    </div>
                </div>
                <a href="tel:+998712326326" class="d-flex instructions align-items-center mb-25">
                    <div class="">
                        <div class="text-dark"><b><span><?= t("Телефон") ?>:</span></b></div>
                        <div class="gray-text"><span>+99871 232 63 64</span></div>
                    </div>
                </a>
                <a href="mailto:info@mineconomy.uz" class="d-flex instructions align-items-center mb-25">
                    <div class="">
                        <div class="text-dark"><b><span><?= t("E-mail") ?>:</span></b></div>
                        <div class="gray-text"><span>info@mineconomy.uz</span></div>
                    </div>
                </a>
                <div class="d-flex instructions align-items-center mb-25">
                    <div class="">
                        <div class="text-dark"><b><span><?= t("Адрес") ?>:</span></b></div>
                        <div class="gray-text"><span>ул. Ислама Каримова, 45а, Ташкент, Узбекистан 100003</span></div>
                    </div>
                </div>

            </div>
            <div class="col-md-7">
                <iframe style="border: 0;" src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d2119.1477732881453!2d69.2574303655825!3d41.31044031383369!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x38ae8b1a2e3db32f%3A0x52a6fae6f93d02da!2z0JzQuNC90LjRgdGC0LXRgNGB0YLQstC-INGN0LrQvtC90L7QvNC40LrQuCwgNDUgQSBVemJla2lzdGFuIEF2ZW51ZSwgVGFzaGtlbnQgMTAwMDAz!3m2!1d41.3103208!2d69.2573018!5e0!3m2!1sru!2s!4v1576166720510!5m2!1sru!2s" width="100%" height="450" frameborder="0"></iframe>
            </div>

        </div>
    </div>
</div>