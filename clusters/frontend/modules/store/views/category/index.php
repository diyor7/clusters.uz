<?php
if ($company) {
    $this->title = $company->name;
} else {
    $this->title = t("Электронный магазин");
}
?>
<div class="bg-white">
    <div class="container py-30">
        <div class="d-flex align-items-start">
            <div class="mr-20">
                <a href="<?= toRoute('/store/category') ?>">
                    <img src="/img/newplatform1.png" alt="">
                </a>
            </div>
            <div>
                <h1 class="new-title-4 mb-0 pt-2">
                    <?= $this->title ?>
                </h1>
            </div>
        </div>

        <div class="new-breadcrumbs d-flex align-items-center">
            <a href="<?= toRoute('/') ?>"><?= t("Главная") ?></a>
            <span></span>
            <p><?= $this->title ?></p>
        </div>
    </div>
</div>
<div class="new-bg-different">
    <div class="container py-40 mh-40">
        <div class="categories__nav sticky-top mb-15 wow fadeInUp new-bg-different">
            <?php if (count($models) === 0) : ?>
                <h6><?=t("Ничего не найдено")?></h6>
            <?php endif ?>
            <div id="categories" class="row">
                <?php foreach ($models as $category) : ?>
                    <div class="col-md-4 col-lg-4 mb-25">
                        <div class="item shadow position-relative rounded d-flex align-items-center h-100">
                            <div class="item__img shadow mr-15" style="background-image: url('<?= $category->path ?>')"></div>
                            <div class="item__name"><a class="stretched-link" href="<?= toRoute($company ? ['/store/' . $category->url, 'company_id' => $company->id] : ['/store/' . $category->url]) ?>"><?= $category->title ?></a></div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>

<?php $this->registerJs('
$(document).ready(function(){

});
', \yii\web\View::POS_END); ?>