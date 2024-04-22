<?php

?>
<div class="product-list pb-10 mt-40">
    <div class="row product-list__item bg-white pb-20">
        <div class="col-lg-2 w-100">
            <a href="#!" class="add-to-favorite" data-product_id="<?= $product->id ?>" title="<?= Yii::$app->user->isGuest ? t("Нужна авторизация") : "" ?>">
                <span class="star <?= $product->isFavorite ? 'on' : 'off' ?>"></span>
            </a>
            <a class="d-block h-100" href="<?= toRoute('/product/' . $product->url) ?>">
                <p class="product-list__item__image p-10 mh-100" style="background: url('<?= $product->path ?>')">
                    <!--+star-->
                </p>
            </a>
        </div>
        <div class="col-lg-10">
            <div class="float-left w-75">
                <a class="d-block" href="<?= toRoute('/' . $product->category->url) ?>">
                    <p class="product__item__description pr-40 mb-5" title="<?= $product->category->title ?>"><?= $product->category->title ?></p>
                </a>
                <a class="d-block" href="<?= toRoute('/product/' . $product->url) ?>">
                    <p class="product__item__title pr-40 font-weight-bold pb-0"><?= $product->title ?></p>
                </a>
                <p class="product__item__shorttext pr-40 pb-0">
                </p>
                <div class="col-7 pl-0 mb-15"><?= shorter($product->description, 150) ?></div>
                <div class="product-list__item__parametres">
                    <ul class="nav">
                        <?php foreach ($product->productProperties as $productProperty) : ?>
                            <?php if ($productProperty->propertyValue ? $productProperty->propertyValue->value : $productProperty->value) : ?>
                                <li class="font-weight-bold">
                                    <?= $productProperty->property->title ?>:
                                    <span class="font-weight-normal mx-10" href="#!">
                                        <?= $productProperty->propertyValue ? $productProperty->propertyValue->value : $productProperty->value ?>
                                        <?= $productProperty->property->count_unit ?>
                                    </span>
                                </li>
                            <?php endif ?>
                        <?php endforeach ?>
                    </ul>
                </div>
                <!-- <p class="pt-20 mb-0"><a class="gray-text underline-text" href="#">Барча хусусиятлар</a></p> -->
            </div>

            <div class="float-right text-right pt-40">
                <?php if ($product->price_old && $product->price_old > $product->price) : ?>
                    <p class="product__item__old-price mb-0"> <span class="price-through"><?= showPrice($product->price_old) ?> <?= t('сум') ?></span> <span class="sale-percent-badge">-<?= round(($product->price_old - $product->price) / $product->price_old * 100) ?>%</span></p>
                <?php endif ?>

                <p class="product__item__price mb-5 font-weight-bold"><?= showPrice($product->price) ?> <?= t('сум') ?></p>

                <div class="product-list__item__footer pb-0 mb-0 mt-15">
                    <a rel="nofollow" href="<?= toRoute('/product/' . $product->url . '?delivery_tab=1') ?>">
                        <p><?= t("Варианты и условия доставки") ?></p>
                    </a>
                    <a rel="nofollow" href="<?= toRoute('/product/' . $product->url . '?delivery_tab=1') ?>">
                        <p><?= t("Виды и условия оплаты") ?></p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>