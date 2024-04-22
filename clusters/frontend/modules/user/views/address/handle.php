<?php

use yii\bootstrap\Html;

$this->title = t("Адрес");

$this->params['breadcrumbs'][] = array(
    'label' => t("Личный кабинет"),
    'url' => toRoute('/user')
);
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render("../layouts/_nav") ?>

<div class="new-bg-different py-30">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?= $this->render("../layouts/_menu") ?>
            </div>
            <div class="col-md-9">
                <div class="shadow rounded bg-white p-20 fs-15">
                    <?php $form =  \yii\bootstrap\ActiveForm::begin([
                        'method' => 'POST',
                        'options' => [
                            'class' => 'form'
                        ]
                    ]) ?>
                    <div class="form-group mb-25">
                        <?= $form->field($model, 'name')->input('text', [
                            'class' => 'form-control py-20 px-30'
                        ]) ?>
                    </div>
                    <div id="map"></div>
                    <?= $form->field($model, 'latitude')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'longitude')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'text')->hiddenInput()->label(false) ?>
                    <div class="text-right">
                        <?= Html::submitButton($model->isNewRecord ? t('Добавить') : t("Редактировать"), ['class' => 'btn btn-secondary rounded-pill py-5  px-45 h-auto']); ?>
                    </div>
                    <?php \yii\bootstrap\ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->registerJs('', \yii\web\View::POS_END); ?>

<script src="https://api-maps.yandex.ru/2.1/?lang=<?= Yii::$app->language == 'uz' ? 'uz_UZ' : (Yii::$app->language == 'ru' ? 'ru_RU' : "en_US") ?>&amp;apikey=5cf94247-5d46-472c-a903-a1bbd9edd976" type="text/javascript"></script>

<script>
    ymaps.ready(function() {
        var myMap = new ymaps.Map('map', {
            center: [<?= $model->latitude ? $model->latitude : 41.311081 ?>, <?= $model->longitude ? $model->longitude : 69.240562 ?>],
            zoom: 12
        }, {
            searchControlProvider: 'yandex#search'
        });

        var placemark = new ymaps.Placemark([<?= $model->latitude ? $model->latitude : 41.311081 ?>, <?= $model->longitude ? $model->longitude : 69.240562 ?>], {}, {
            iconColor: '#ff0000',
            draggable: true
        });

        placemark.events.add('dragend', function(events) {

            var latitude = placemark.geometry.getCoordinates()[0];
            var longitude = placemark.geometry.getCoordinates()[1];

            $("#address-latitude").val(latitude);
            $("#address-longitude").val(longitude);

            var url = "https://nominatim.openstreetmap.org/reverse?lat=" + latitude + "&lon=" + longitude + "&format=json&accept-language=" + $("html").attr("lang");

            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    if (data && data.display_name) {
                        $("#address-text").val(data.display_name);
                    }
                }
            });
        });

        myMap.events.add('click', function(e) {
            // Получение координат щелчка
            var coords = e.get('coords');
            placemark.geometry.setCoordinates(coords);

            var latitude = coords[0];
            var longitude = coords[1];

            $("#address-latitude").val(latitude);
            $("#address-longitude").val(longitude);
        });

        myMap.geoObjects.add(placemark);
    });
</script>

<style>
    #map {
        width: 100%;
        height: 500px;
        padding: 0;
        margin: 0;
    }
</style>