<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use frontend\widgets\FeedbackForm;
/* @var $company \common\models\Company */
/* @var $category \common\models\Category */
/* @var $products \common\models\Product */
/* @var $product \common\models\Product */
/* @var $pagination  */
$this->title = 'Потребность'
?>
<div class="new-bg-different">
    <div class="container py-30">
        <div class="d-flex align-items-start mb-15">
            <div class="mr-20">
                <img src="<?=$company->logo?>" alt="">
            </div>
            <div>
                <h1 class="new-title-4 mb-0 pt-2">
                    <?=$company->full_name?>
                    <?php // $type==1?Yii::t('frontend', 'Выпускаемая продукция'):Yii::t('frontend', 'Закупки')?>
                </h1>
            </div>
        </div>

        <div class="new-breadcrumbs d-flex align-items-center">
            <a href="<?= toRoute('/') ?>"><?=t("Главная")?></a>
            <span></span>
            <a href="#"><?=$company->full_name?></a>
            <span></span>
            <a href="<?=Url::to(['/organisation/agmk/index', 'id' => $company->id, 'type' => 0])?>">Потребность</a>
            <span></span>
            <a href="<?=Url::to(['/organisation/agmk/index', 'id' => $company->id, 'type' => $type])?>"><?=$category->getType($type)?></a>
            <span></span>
            <a class="disabled-link"><?=$category->name?></a>
        </div>
    </div>
</div>

<div class="container z-index-1 bg-white position-relative px-40 mb-35 py-35 mt-50 overflow-hidden">

    <section class="pt-0 mb-60 pb-0 category">
        <h1 class="page-title font-weight-bold fs-36 pb-25" id="page-name"><?=$category->name?></h1>

        <div class="bg-white">
            <div class="category__filter py-40">
                <p class="float-left">
                    <a id="collapseFilterOpener" class="black-link fw-semi-bold" style="cursor: pointer">
                        <?php echo Yii::t('frontend', "Параметры фильтра");?>
                    </a>
                </p>
                <div class="clearfix"></div>
                <div class="mt-20" id="collapseFilter" style="display: none">
                    <div class="">
                        <?= $this->render('_product_search', ['model' => $searchModel]); ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="category__products mb-100 pb-100">
                <table class="table table-bordered text-center fs-14 mt-35 table-hover">
                    <thead>
                    <tr>
                        <th scope="col"><?php echo Yii::t('frontend', "Наименования");?></th>
                        <th scope="col"><?php echo Yii::t('frontend', "ТН ВЭД");?></th>
                        <th scope="col"><?php echo Yii::t('frontend', "Ед. изм.");?></th>
                        <th scope="col" class="text-left"><?php echo Yii::t('frontend', "Технические характеристики");?></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php /** @var object $dataProvider */
                    \yii\widgets\LinkSorter::widget([

                        'sort' => $dataProvider->sort,

                    ]) ?>

                    <?=\yii\widgets\ListView::widget([
                        'dataProvider' => $dataProvider,
                        'options' => [
                            'tag' => false,
                            'class' => '',
                            'id' => '',
                        ],
                        'sorter' => [
                            'options' => [
                                'class' => 'dropdown-menu',
                                'style' => 'padding: 20px !important'
                            ],
                            'attributes' => [
                                'created_at',
//                            'created_at' => [
//                                'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
//                                'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
//                                'default' => SORT_DESC,
//                                'label' => 'Name',
//                            ],
                                'name'
                            ]
                        ],                    //'viewParams' => ['category' => $category],
                        'layout' => '</thead><tbody>{items}</tbody></table><nav aria-label="page-navigation">{pager}</nav>{summary}<div class="dropdown float-right">
        <button class="btn bg-transparent border-dark dropdown-toggle" type="button" data-toggle="dropdown">
            '.Yii::t('frontend', 'Сортировка').'<span class="caret"></span>
        </button>
        {sorter}
    </div>',
                        'itemView' => function ($model, $key, $index, $widget) use ($category, $type, $company) {
                            return $this->render('_product_item',[
                                'product' => $model,
                                'type' => $type,
                                'company' => $company,
                                'index' => $index,
                                'key' => $key,
                            ]);
                        },
                        'itemOptions' => [
                            'tag' => false,
                        ],
                        'pager' => [
                            'hideOnSinglePage' => true,
                            'prevPageLabel' => '<i class="icon-chevron-left"></i>',
                            'nextPageLabel' => '<i class="icon-chevron-right"></i>',

//                                'firstPageLabel' => 'first',
//                                'lastPageLabel' => 'last',
                            'maxButtonCount' => 8,

                            // Настройки контейнера пагинации
                            'options' => [
                                'tag' => 'ul',
                                'class' => 'pagination mb-0 justify-content-center',
                                'id' => 'pager-container',
                            ],

                            // Настройки контейнера пагинации
                            'linkContainerOptions' => [
                                'tag' => 'li',
                                'class' => 'page-item',
                                'id' => '',
                            ],

                            // Настройки классов css для ссылок
                            'linkOptions' => ['class' => 'page-link rounded-circle'],
                            'activePageCssClass' => 'active',
                            'disabledPageCssClass' => 'disabled',

                            // Настройки для навигационных ссылок
//                                'prevPageCssClass' => 'mypre',
//                                'nextPageCssClass' => 'mynext',
//                                'firstPageCssClass' => 'myfirst',
//                                'lastPageCssClass' => 'mylast',

                        ],
                        'emptyTextOptions' =>[
                            'tag' => 'div',
                            'class' => 'alert alert-success col-md-12',
                        ],
                        'emptyText' => Yii::t('frontend', 'Content is being filled')
                    ]);?>
            </div>
        </div>

    </section>
</div>

<?php
$filter = <<<JS
    var copener = $('#collapseFilterOpener');
    var cFilter = $('#collapseFilter');
    
    copener.on('click', function () {
        cFilter.slideToggle();
    })
JS;
$this->registerJs($filter, \yii\web\View::POS_LOAD);
?>
