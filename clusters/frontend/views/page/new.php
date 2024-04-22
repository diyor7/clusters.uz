<?php
$this->title = $model->title;



$this->params['breadcrumbs'][] = $this->title;
?>

<style>
.super-container {
    -webkit-box-align: center !important;
    -ms-flex-align: center !important;
    align-items: center !important;
    -webkit-box-pack: center !important;
    -ms-flex-pack: center !important;
    justify-content: center !important;
    display: -webkit-box !important;
    display: -ms-flexbox !important;
    display: flex !important;
    height: 100%;
}

.container-custom {
    /* height: 330px; */
}

* {
    box-sizing: border-box;
}

/* Carousel container */
.carousel-container {
    max-width: 1000px;
    position: relative;
    margin: auto;
    height: 100%;
    /* max-height: 300px; */
    /* overflow: hidden; */
}

/* Hide the images by default */
.myCarousel {
    display: none;
    height: 100%;
}

.myCarousel img {
    width: 100%;
    /* margin-top: -20%; */
}

/* Next & previous buttons */
.prev,
.next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    margin-top: -22px;
    padding: 16px;
    color: white;
    font-weight: bold;
    font-size: 18px;
    transition: 0.6s ease;
    border-radius: 0 3px 3px 0;
    user-select: none;
}

/* Position the "next button" to the right */
.next {
    right: 0;
    border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
    background-color: rgba(0, 0, 0, 0.8);
}

/* Caption text */
.text {
    color: #f2f2f2;
    font-size: 20px;
    padding: 8px 12px;
    position: absolute;
    bottom: 0px;
    width: 100%;
    text-align: center;
    background: #0000008c;
    line-height: 30px;
}

/* Number text (1/3 etc) */
.numbertext {
    color: #f2f2f2;
    font-size: 12px;
    padding: 12px 20px;
    position: absolute;
    top: 0;
    background: #000000ba;
}

/* The dots/bullets/indicators */
.dot {
    cursor: pointer;
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: #fff;
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.6s ease;
}

.active-custom,
.dot:hover {
    background-color: #3f3f3f;
}

/* Fading animation */
.fade-custom {
    -webkit-animation-name: fade;
    -webkit-animation-duration: 1.5s;
    animation-name: fade;
    animation-duration: 1.5s;
}

@-webkit-keyframes fade {
    from {
        opacity: 0.4;
    }

    to {
        opacity: 1;
    }
}

@keyframes fade {
    from {
        opacity: 0.4;
    }

    to {
        opacity: 1;
    }
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
            <a href="<?= toRoute('/') ?>"><?= t("Главная") ?></a>
            <span></span>
            <a href="<?= toRoute('/page/news') ?>"><?= t("Новости") ?></a>
            <span></span>
            <p><?= $this->title ?></p>
        </div>
    </div>
</div>

<div class="new-bg-different">
    <div class="container py-40">
        <div class="row">
            <div class="col-md-9">
                <?php if($model->images && count($model->images) > 0): ?>
                <div class="row">
                    <!-- <div class="col-md-3"></div> -->
                    <div class="col-md-12">
                        <div class="super-container">
                            <div class="container-custom">
                                <div class="carousel-container">
                                    <?php foreach($model->images as $md2): ?>
                                        <div class="myCarousel fade-custom">
                                            <!-- <div class="numbertext">1 / 3</div> -->
                                            <img src="<?=$md2->imageurl?>"
                                                style="width:100%">
                                        </div>
                                    <?php endforeach ?>

                                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="row">
                <?= $model->description ?>
                

                </div>
                <div class="row justify-content-between">
                    <p>
                        <?= $model->created_at ?>
                        <span class="line" style="font-size: 14px; line-height: 20px; margin: 0 10px;">|</span> 
                        <img src="/img/eye.png"> 
                        <?= $model->views ?>
                    </p>
                    <p>
                        <?=t("Поделиться")?>:
                        <a href="https://t.me/share/url?url=<?=siteUrl() . '/page/new/' . strtolower(rus2translit($model->title)) . '--' . $model->id ?>&text=<?= $model->title ?>" target="_blank">
                            <img src="/img/telegram-logo.png" width="20">
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?=siteUrl() . '/page/new/' . strtolower(rus2translit($model->title)) . '--' . $model->id ?>&text=<?= $model->title ?>" target="_blank">
                            <img src="/img/facebook-logo.png" width="20">
                        </a>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <?php foreach($models as $md): ?>
                <div class="new-item new-product">
                    <div>
                        <a
                            href="<?= toRoute(['/page/new/' . strtolower(rus2translit($md->title)) . '--' . $md->id]) ?>">
                            <div class="image">
                                <img src="<?= $md->imageurl ? $md->imageurl : '/img/noimage.jpg' ?>"
                                    alt="<?= $md->title ?>" class="w-100">
                            </div>
                        </a>
                        <div class="info">
                            <div class="count d-flex justify-content-between">
                                <div>
                                    <?= date("d.m.Y", strtotime($md->created_at)) ?>
                                </div>
                            </div>
                            <a
                                href="<?= toRoute(['/page/new/' . strtolower(rus2translit($md->title)) . '--' . $md->id]) ?>">
                                <div class="price mb-25">
                                    <?= $md->title ?>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>

<script>
let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
    showSlides((slideIndex += n));
}

// Thumbnail image controls
function currentSlide(n) {
    showSlides((slideIndex = n));
}

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("myCarousel");
    let dots = document.getElementsByClassName("dot");
    if (n > slides.length) {
        slideIndex = 1;
    }
    if (n < 1) {
        slideIndex = slides.length;
    }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
}
</script>

<?php $this->registerJs('

', \yii\web\View::POS_END); ?>