<?php
/* @var $this yii\web\View */

$this->title = t("Единый электронный информационно-интерактивный торговый портал по отечественному Кластеру медной промышленности");
?>

<div class="container p-50">
    <div class="companies">
        <h2 class="title text-uppercase mb-30 mt-20 text-center">Закупы по площадкам</h2>
        <div class="row my-50">
            <div class="col-md-6">
                <a href="<?= toRoute('/store') ?>">
                    <div class="company rounded-lg bg-white py-50 px-20 mb-30">
                        <div style="background-image: url(/img/elektron-dokon.svg)" class="company__logo mb-20"></div>
                        <div class="company__name text-center mb-10"><?= t("Электронный магазин") ?></div>
                        <div class="company__text text-center">Государственная закупка однотипных товаров</div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="<?= toRoute('/auction') ?>">
                    <div class="company rounded-lg bg-white py-50 px-20 mb-30">
                        <div style="background-image: url(/img/auksion.svg)" class="company__logo mb-20"></div>
                        <div class="company__name text-center mb-10"><?= t("Аукцион") ?></div>
                        <div class="company__text text-center">Аукцион на понижение стартовой цены - Государственная закупка товаров со стандартными свойствами</div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="#!" onclick="toastr.info('На стадии разработки')">
                    <div class="company rounded-lg bg-white py-50 px-20 mb-30">
                        <div style="background-image: url(/img/tender.svg)" class="company__logo mb-20"></div>
                        <div class="company__name text-center mb-10"><?= t("Тендер") ?></div>
                        <div class="company__text text-center">Критерии определения победителя имеют не только денежную оценку, но количественную и качественную оценку товара (работы, услуги)</div>

                    </div>
                </a>
            </div>
            <div class="col-md-6" onclick="toastr.info('На стадии разработки')">
                <a href="#!">
                    <div class="company rounded-lg bg-white py-50 px-20 mb-30">
                        <div style="background-image: url(/img/konkurs.svg)" class="company__logo mb-20"></div>
                        <div class="company__name text-center mb-10"><?= t("Электронный конкурс ") ?></div>
                        <div class="company__text text-center">Критерии определения победителя имеют не только денежную, но количественную и качественную оценку государственной закупки товара (работы, услуги)</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs("
    
", \yii\web\View::POS_END);
?>