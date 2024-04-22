<?php
$this->title = t("Адрес");

$this->params['breadcrumbs'][] = array(
    'label' => t("Личный кабинет"),
    'url' => toRoute('/user')
);
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render("../layouts/_nav", [
    'btn_title' => t("Добавить новый адрес"),
    'btn_url' => toRoute("/user/address/create")
]) ?>

<div class="new-bg-different py-30">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?= $this->render("../layouts/_menu") ?>
            </div>
            <div class="col-md-9">

                <div class="products mb-30">
                    <?php if (count($addresses) == 0) : ?>
                        <h5 class=" pt-10 mt-20 mb-10"><?= t("Ничего не найдено") ?></h5>
                    <?php endif ?>
                    <div class="product-grid">
                        <div class="row mx-n10 mx-xxl-n15">
                            <?php foreach ($addresses as $address) : ?>
                                <div class="col-4 col-xxl-4 px-10 px-xxl-15 mb-20 mb-xxl-30">
                                    <div class="product d-flex shadow h-100 wow fadeInUp">
                                        <div class="product__content h-100 d-flex align-content-between flex-wrap rounded-left position-relative w-100">
                                            <div>
                                                <div class="product__content-top">
                                                    <img class="w-100" src="https://static-maps.yandex.ru/1.x/?lang=<?= Yii::$app->language ?>&ll=<?= $address->longitude ?>,<?= $address->latitude ?>&size=650,200&z=12&l=map" alt="">
                                                </div>
                                                <div class="product__content-bottom mt-15 w-100">
                                                    <div class="product__price product__price--new">
                                                        <?= $address->name ?>
                                                    </div>
                                                    <div class="product__tn">
                                                        <?= $address->text ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <a class="float-right" data-method="POST" data-confirm="<?= t('Вы уверены?') ?>" href="<?= toRoute('/user/address/delete/' . $address->id) ?>">
                                                    <i class="icon-trash"></i>
                                                </a>
                                                <div class="dropdown d-inline-block float-right mr-25">
                                                    <a id="product_action_1" href="<?= toRoute('/user/address/update/' . $address->id) ?>">
                                                        <i class="icon-edit"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->registerJs('', \yii\web\View::POS_END); ?>