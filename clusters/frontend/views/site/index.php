<?php
/* @var $this yii\web\View */
$this->title = t("Информационно-интерактивный торговый портал кластера медной промышленности");
?>
    <!--confireansiya uchun-->
    <a href="#!" id="request_modal" data-toggle="modal" data-target="#requestClusterModal2" ></a>
<div class="new-welcome new-bg-different">
    <div class="container">

        <h1 class="new-title-1 text-center"><?= t("Предприятия кластера <b>медной промышленности</b>") ?></h1>

        <div class="row mt-50">
            <div class="col-lg-3 col-md-6 d-flex">
                <a class="d-flex" href="<?= toRoute(['/cluster/agmk']) ?>">
                    <div class="new-cluster">
                        <div class="image text-center">
                            <img src="/img/newcluster1.png" alt="">
                        </div>
                        <div class="name">
                            <?= t("Алмалыкский горно-металлургический комбинат") ?>
                        </div>
                        <div class="mt-10">
                            <button class="red-btn border-0 text-center">
                                <?= t("Потребность") ?>
                            </button>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 d-flex">
                <!-- <a class="d-flex" href="<?= toRoute(["/organisation/uzeltech/index", 'type' => 0]) ?>"> -->
                <a class="d-flex" href="<?= toRoute(['/cluster/agmk']) ?>">
                    <div class="new-cluster">
                        <div class="image text-center">
                            <img src="/img/newcluster2.png" alt="">
                        </div>
                        <div class="name">
                            <?= t("Ассоциацию электротехнических предприятий Узбекистана") ?>
                        </div>
                        <div class="mt-10">
                            <button class="red-btn text-center border-0">
                                <?= t("Потребность") ?>
                            </button>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 d-flex">

                <!-- <a class="d-flex" href="<?= toRoute(["/organisation/umk/index"]) ?>"> -->
                <a class="d-flex" href="<?= toRoute(['/cluster/ngmk']) ?>">
                    <div class="new-cluster">
                        <div class="image text-center">
                            <img src="/img/newcluster3.png" alt="">
                        </div>
                        <div class="name">
                            <?= t("Узбекский металлургический комбинат") ?>
                        </div>
                        <div class="mt-10">
                            <button class="border-0 red-btn text-center">
                                <?= t("Потребность") ?>
                            </button>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 d-flex">
                <a class="d-flex" href="<?= toRoute(['/cluster/ngmk']) ?>">
                    <div class="new-cluster">
                        <div class="image text-center">
                            <img src="/img/newcluster4.png" alt="">
                        </div>
                        <div class="name">
                            <?= t("Навоийский горно-металлургический комбинат") ?>
                        </div>
                        <div class="mt-10">
                            <button class="border-0 red-btn text-center">
                                <?= t("Потребность") ?>
                            </button>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="new-bg-different">
    <div class="container py-40">
        <div class="row">
            <div class="col-md-12 mt-4 mb-50">
                <h3 class="new-title-2"><?= t("Последние <b> новости</b>") ?></h3>
            </div>
            <div class="col-md-6 col-sm-12 p-2">
                <div class="small-post">
                    <a href="<?= toRoute(['/page/new/' . strtolower(rus2translit($model->title)) . '--' . $model->id]) ?>" class="w-100">
                        <div class="new-post-thumb">
                            <img src="<?= $model->imageurl ? $model->imageurl : '/img/noimage.jpg' ?>" alt="<?= $model->title ?>">
                        </div>
                        <div class="new-post-body new-post-title">
                            <h4 class="new-post-title"><?= $model->title ?></h4>
                            <p><?= date("d.m.Y", strtotime($model->created_at)) ?></p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 p-2">
                <?php foreach ($models as $md) : ?>
                    <div class="small-post mb-4">
                        <a class="d-flex" href="<?= toRoute(['/page/new/' . strtolower(rus2translit($md->title)) . '--' . $md->id]) ?>">
                            <div class="sm-thumbnail">
                                <img src="<?= $md->imageurl ? $md->imageurl : '/img/noimage.jpg' ?>" alt="<?= $md->title ?>">
                            </div>
                            <div class="new-post-title px-3">
                                <h4 class="new-post-title">
                                    <?= $md->title ?>
                                </h4>
                                <p><?= date("d.m.Y", strtotime($md->created_at)) ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-md-12 mt-1 mb-10">
                <p class="text-right"> <b> <a href="<?= toRoute(['/page/news']) ?>"> <?= t("Все") ?>... </a> </b></p>
            </div>
        </div>
    </div>
</div>

<!-- <div class="new-bg-different">
    <div class="container py-40">
        <h3 class="new-title-2"><?=''// t("Закупки <b>по площадкам</b>") ?></h3>

        
    </div>
</div> -->



<div class="bg-white">
    <div class="container py-40">
        <h2 class="new-title-3"><?= t("Система интегрирована со следующими <b>государственными органами</b>") ?></h2>

        <div class="row my-60 govs">
            <div class="col-lg-2 d-flex align-items-start justify-content-center">
                <div class="gov">
                    <div class="image">
                        <img src="/img/gos1.png" alt="">
                    </div>
                    <p><?= t("Министерство финансов Республики Узбекистан") ?></p>
                </div>
            </div>
            <div class="col-lg-2 d-flex align-items-start justify-content-center">
                <div class="gov">
                    <div class="image">
                        <img src="/img/gos2.png" alt="">
                    </div>
                    <p><?= t("Государственный налоговый комитет Республики Узбекистан") ?></p>
                </div>
            </div>
            <div class="col-lg-2 d-flex align-items-start justify-content-center">
                <div class="gov">
                    <div class="image">
                        <img src="/img/gos3.png" alt="">
                    </div>
                    <p><?= t("Государственный Таможенный Комитет Республики Узбекистан") ?></p>
                </div>
            </div>
            <div class="col-lg-2 d-flex align-items-start justify-content-center">
                <div class="gov">
                    <div class="image">
                        <img src="/img/gos4.png" alt="">
                    </div>
                    <p><?= t("Государственный комитет промышленной безопасности Республики Узбекистан") ?></p>
                </div>
            </div>
            <div class="col-lg-2 d-flex align-items-start justify-content-center">
                <div class="gov">
                    <div class="image">
                        <img src="/img/gos5.png" alt="">
                    </div>
                    <p><?= t("Государственный комитет Республики Узбекистан по статистике") ?></p>
                </div>
            </div>
            <div class="col-lg-2 d-flex align-items-start justify-content-center">
                <div class="gov">
                    <div class="image">
                        <img src="/img/gos6.png" alt="">
                    </div>
                    <p><?= t("Узбекское агентство по техническому регулированию") ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJs("
    $(document).ready(function() {
        var swiper = new Swiper('.mySwiper', {
            direction: 'vertical',
            speed: 600,
            
            slidesPerView: 1,
            spaceBetween: 0,
            mousewheel: true,
            // allowTouchMove: false
        });

        window.swiper = swiper;

        var productPwiper = new Swiper('.product-swiper', {
            slidesPerView: 5,
            spaceBetween: 28,
            mousewheel: true,
        });
    });
    
    document.addEventListener('DOMContentLoaded',function(){
    setTimeout(load, 1000)
});
 function load(){
    //document.getElementById('request_modal').click();
 }
", \yii\web\View::POS_END);
?>
