<?php

?>
<div class="<?=$className ? $className : "col-lg-3"?> mb-35">
    <a href="<?= toRoute('/store/product/' . $product->url) ?>">
        <div class="new-product">
            <div class="image">
                <img class="img-fluid" src="<?= $product->path ?>" alt="">
            </div>

            <div class="info">
                <div class="count d-flex justify-content-between">
                    <div>
                        №<?= $product->id ?>
                    </div>
                    <div class="text-right">
                        <?=t("{m} шт. продано", [
                                'm' => 0
                        ])?>
                    </div>
                </div>

                <div class="name">
                    <?= $product->title ?>
                </div>

                <div class="stars my-3">
                    <img src="/img/new-stars.png" alt="">
                </div>

                <div class="price">
                    <?= showPrice($product->price) ?> <?= t("сум") ?>
                </div>
            </div>
        </div>
    </a>
</div>