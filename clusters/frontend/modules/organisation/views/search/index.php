<?php
$this->title = t("Поиск по товарам");

$this->params['breadcrumbs'][] = $this->title;
?>

<h1 class="d-page__content-title pb-40 decorated decorated-right"><?= $query ?></h1>

<div class="container-fluid">
    <div class="products mb-50">
        <div class="product__filter pb-0">
            <!-- <div class="product__filter__title"><a href="#" data-toggle="modal" data-target="#filter-modal"><?= t("Фильтр") ?><img class="mx-10" src="/img/filter.svg"></a></div> -->

            <div class="product__filter__view float-right">
                <?= t("Вид") ?>
                <a class="ml-10 <?= $layout == 'grid' ? 'active' : '' ?>" href="<?= toRoute(['/search', 'query' => $query, 'layout' => "grid"]) ?>">
                    <img src="/img/grid.svg">
                </a>
                <a class="ml-10 <?= $layout == 'list' ? 'active' : '' ?>" href="<?= toRoute(['/search', 'query' => $query, 'layout' => "list"]) ?>">
                    <img src="/img/list.svg">
                </a>
            </div>
        </div>
        <div class="product-grid">
            <h2 class="title text-uppercase mb-40 wow fadeInUp"><?= t("Результаты поиска") ?></h2>

            <div class="row mx-n10 mx-xxl-n15">
                <div class="row pt-0">
                    <?php foreach ($products as $product) : ?>
                        <?= \frontend\widgets\Product::widget(['product' => $product]) ?>
                    <?php endforeach ?>
                </div>
                <?php if (count($products) == 0) : ?>
                    <h5><?= t("Ничего не найдено") ?></h5>
                <?php endif ?>
            </div>

        </div>

        <?php if (count($products) > 0) : ?>
            <?= \frontend\widgets\MyPagination::widget(['pages' => $pages, 'count' => count($products)]) ?>
        <?php endif ?>
    </div>
</div>

<div class="product_filter modal show fade catalogue pr-0" id="filter-modal" tabindex="-1" role="dialog" aria-labelledby="filter-modal">
    <div class="modal-dialog" role="document">
        <form class="modal-content animate-bottom px-40 pt-50 pb-100 d-inline-block">
            <h2 class="primary-text font-weight-bold fs-20 mb-20">Фильтр<a class="float-right" href="#" data-dismiss="modal" aria-label="Close"><i class="icon_close"></i></a></h2>
            <div class="catalogue__items mb-50">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group pb-15">
                            <label for="name_p">Маҳсулот номи ёки рақами</label>
                            <input class="form-control" placeholder="Номи ёки рақамини киритинг..." id="name_p">
                        </div><a class="my-15 gray-text-dark d-block" data-toggle="collapse" href="#filter-item-1" role="button" aria-expanded="true" aria-controls="filter-item-1">Совутиш камерасининг музлатилиши</a>
                        <div class="collapse" id="filter-item-1">
                            <div class="selectable-blocks mx-n5">
                                <div class="form_radio_btn">
                                    <input id="radio-1" type="checkbox" name="address" value="1" checked="">
                                    <label class="d-inline-block p-10 m-5 fs-14 gray-text-darker" for="radio-1">No Frost</label>
                                </div>

                            </div>
                        </div>
                        <div class="clearfix"></div><a class="my-15 gray-text-dark d-block" data-toggle="collapse" href="#filter-item-2" role="button" aria-expanded="true" aria-controls="filter-item-2">Бундан ташқари</a>
                        <div class="collapse" id="filter-item-2">
                            <div class="selectable-blocks mx-n5">
                                <div class="form_radio_btn">
                                    <input id="radio-1" type="checkbox" name="address" value="1" checked="">
                                    <label class="d-inline-block p-10 m-5 fs-14 gray-text-darker" for="radio-1">No Frost</label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-15">Маҳсулот нархи</div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <!--label(for="name_p") Маҳсулот номи ёки рақами-->
                                    <input class="form-control" placeholder="дан" id="name_p">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <!--label(for="name_p") Маҳсулот номи ёки рақами-->
                                    <input class="form-control" placeholder="қадар" id="name_p">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Тоифаси</label>
                            <div class="custom-select dropdown-toggle p-0 text-left font-family-roboto gray-text fs-14 font-weight-normal" style="width:386px;">
                                <select name="type">
                                    <option value="0">Тоифани танланг</option>
                                    <option value="1">Тизимдаги ҳисобингиздан</option>
                                    <option value="2">Банк ҳисоб карталари</option>
                                    <option value="3">Тўлов тизимлари </option>
                                </select>
                                <div class="select-selected">Тоифани танланг</div>
                                <div class="select-items select-hide">
                                    <div>Тизимдаги ҳисобингиздан</div>
                                    <div>Банк ҳисоб карталари</div>
                                    <div>Тўлов тизимлари </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="name_p">Форма мавзуси</label>
                            <input class="form-control" placeholder="Қиймати" id="name_p">
                        </div>
                    </div>
                </div>
            </div>
            <div class="fixed-bottom text-center px-40 py-20 d-flex align-items-center bg-white"><a class="float-left gray-text-dark font-weight-bolder fs-15" href="/products.html"><i class="icon_left_narrow mr-10"></i>Бекор қилиш ва қайтиш</a>
                <div class="d-inline-block m-auto"><a class="btn rounded-pill px-30 font-weight-bold" href="/products.html">758 та таклифни курсатиш</a></div>
                <div class="float-right">
                    <button class="float-left gray-text-dark font-weight-bolder fs-15 bg-white" type="reset"><i class="icon_close mr-10"></i>Фильтрларни тозалаш </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php $this->registerJs('', \yii\web\View::POS_END); ?>