<?php
use yii\helpers\Url;
use common\models\organisation\agmk\Product;

/** @var $product \common\models\Product */
/** @var  $type */

$currency = ($product->currency == 0)?($type == 0)?Product::getNameCurrency(1):Product::getNameCurrency(4):$product->getNameCurrency($product->currency);
?>
<tr>
    <td >
        <a href="<?=Url::to(['/organisation/agmk/product', 'id' => $product->id, 'type' => $type])?>" class="black-link d-flex align-items-center">
            <img src="/organisations/<?=$company->folder?><?=$product->image?>" alt="" width="100" class="float-left mr-10">
            <span class="font-weight-bold"><?=$product->name?></span>
        </a>
    </td>
    <td><?=$product->code?></td>
    <td><?=$product->units_measure_id?></td>
    <td class="text-left"><?=$product->description?></td>
</tr>

