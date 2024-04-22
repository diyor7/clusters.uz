<section>
    <div class="container">
        <h1 class="text-header"><?=getTranslate("Похожие товары")?></h1>
        <div class="row">
            <?php foreach ($products as $product):?>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                    <div class="product hoverable p-2">
                        <!--Carousel Wrapper-->
                        <div id="carousel-catalog-<?=$product->product_id?>" class="carousel slide carousel-fade" data-ride="carousel">
                            <!--Indicators-->
                            <ol class="carousel-indicators">
                                <?php $index = 0; foreach($product->images as $image):?>
                                    <li data-target="#carousel-catalog-<?=$product->product_id?>" data-slide-to="<?=$index?>" class="<?=$index++ == 0 ? 'active' : ''?>"></li>
                                <?php endforeach?>
                            </ol>

                            <!--/.Indicators-->
                            <!--Slides-->
                            <a href="<?=toRoute("/product/$product->product_id")?>">
                                <div class="carousel-inner mt-2" role="listbox">
                                    <?php $index = 0; foreach($product->images as $image):?>
                                        <div class="carousel-item <?=$index++ == 0 ? 'active' : ''?>">
                                            <img class="d-block w-100" src="<?=$image->image?>" alt="<?=$image->alt?>">
                                        </div>
                                    <?php endforeach?>
                                </div>
                            </a>
                            <!--/.Slides-->
                            
                        </div>
                        <!--/.Carousel Wrapper-->
                        <a href="<?=toRoute("/product/$product->product_id")?>" class="product-title">
                            <?=$product->title?>
                        </a>
                        <div class="product-price">
                            <span class="sale-price fs-18 font-italic mx-0 px-0 text-bold-red">
                                <?=$product->price2?> <?=getTranslate("sum")?>.
                            </span>
                            <?php if ($product->price_old):?>
                                <span class="sale-price-line">
                                    <?=$product->price_old2?> <?=getTranslate("sum")?>.
                                </span>
                            <?php endif?>

                            
                        </div>
                        <div class="product-cart text-center pt-2">
                            <?php if ($product->quantity > 0):?>
                                <a  data-id='<?=$product->product_id;?>' href="<?=toRoute(['product/add-to-cart', 'product_id'=>$product->product_id])?>" class="btn add-to-cart-btn btn-add-to-cart fs-18 btn-md">
                                    <?=getTranslate("В корзину")?>
                                </a>
                            <?php else:?>
                                <a data-toggle="modal" data-target="#emptyModal" data-title='<?=$product->title;?>' data-vendor="<?=$product->vendor_code;?>" data-image="<?=count($product->images) > 0 ? $product->images[0]->image : ''?>" href="javascript: 0" class="btn btn-add-to-cart btn-empty fs-18 btn-md">
                                    <?=getTranslate("В корзину")?>
                                </a>
                            <?php endif?>
                        </div>
                    </div>
                </div>
            <?php endforeach?>  
        </div>

    </div>
</section>