<?php

use common\models\ProductProperty;
use common\models\PropertyValue;

?>

<?php if (count($properties) > 0) : ?>
    <?php foreach ($properties as $property) : ?>
        <?php $property_values = PropertyValue::findAll(['property_id' => $property->id]); ?>
        <?php $product_property = ProductProperty::findOne(['product_id' => $product_id, 'property_id' => $property->id]) ?>

        <?php if (count($property_values) == 0) : ?>
            <div class="form-group mb-25">
                <div class="form-group field-product-properties-<?= $property->id ?>">
                    <label class="control-label" for="product-properties-<?= $property->id ?>"><?= $property->title ?></label>
                    <input type="text" id="product-properties-<?= $property->id ?>" class="form-control py-20 px-30" name="Product[properties][<?= $property->id ?>]" value="<?= $product_property ? $product_property->value : "" ?>">
                    <p class="help-block help-block-error"></p>
                </div>
            </div>
        <?php else : ?>
            <div class="form-group mb-25">
                <div class="form-group field-product-property_values-<?= $property->id ?>">
                    <label class="control-label" for="product-property_values-<?= $property->id ?>"><?= $property->title ?></label>
                    <select id="product-property_values-<?= $property->id ?>" class="form-control px-30" name="Product[property_values][<?= $property->id ?>]" value="<?= $product_property ? $product_property->property_value_id : "" ?>">
                        <option value="">- Выберите - </option>
                        <?php foreach ($property_values as $pv) : ?>
                            <option <?= $product_property && $product_property->property_value_id == $pv->id ? 'selected' : '' ?> value="<?= $pv->id ?>">
                                <?= $pv->value ?>
                            </option>
                        <?php endforeach ?>
                    </select>

                    <p class="help-block help-block-error"></p>
                </div>
            </div>
        <?php endif ?>
    <?php endforeach ?>
<?php endif ?>