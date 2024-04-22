<?php
/* @var $this yii\web\View */

use common\models\Product as ModelsProduct;
use frontend\widgets\Product;

$this->title = t("Единый электронный информационно-интерактивный торговый портал по отечественному Кластеру медной промышленности");
?>
<main class="position-relative">
    <div class="container-fluid">
        <div class="catalog my-20 mb-xxl-10">
            <h2 class="title text-uppercase mb-40 wow fadeInUp">Категории продуктов</h2>
            <div class="row mx-n10 mx-xxl-n15">
                <?php foreach ($categories as $i => $category) : ?>
                    <div class="col-4 col-xxl-3 px-10 px-xxl-15 mb-20 mb-xxl-30">
                        <div class="item rounded-lg shadow position-relative bg-white d-flex align-items-center p-20 wow fadeInUp">
                            <div class="item__img shadow mr-20">
                                <div class="item__img-holder" style="background-image: url('<?= $category->path ?>')"></div>
                            </div>

                            <div class="item__content">
                                <div class="item__name">
                                    <a href="<?= toRoute('/' . $category->url) ?>" class="item__link stretched-link"><?= $category->title ?></a>
                                </div>
                                <div class="item__count">Кол-во товаров: <?= ModelsProduct::find()->where(['category_id' => $category->id, 'status' => ModelsProduct::STATUS_ACTIVE])->count() ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>

        <div class="products mb-30">
            <h2 class="title text-uppercase mb-40 wow fadeInUp"><?=t("Популярные продуты")?></h2>
            <div class="product-grid">
                <div class="row mx-n10 mx-xxl-n15">

                    <?php foreach ($products as $product) : ?>
                        <?= Product::widget(['product' => $product]) ?>
                    <?php endforeach ?>

                </div>
            </div>
        </div>
    </div>
</main>

<?php
$this->registerJs("
    
", \yii\web\View::POS_END);
?>