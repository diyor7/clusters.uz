<?php

use yii\helpers\Html;
?>
<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $current->name; ?></a>
<div style="min-width: auto;" class="dropdown-menu" aria-labelledby="navbarDropdownLanguageMenuLink">
    <?php foreach ($langs as $lang) : ?>

        <?= Html::a($lang->name, '/' . $lang->url . Yii::$app->getRequest()->getLangUrl(), ['class' => 'dropdown-item']) ?>
    <?php endforeach; ?>
</div>