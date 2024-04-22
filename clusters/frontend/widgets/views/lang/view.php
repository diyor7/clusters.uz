<?php

use yii\helpers\Html;
?>
<div class="dropdown tool">
    <a class="nav-link dropdown-toggle p-0" href="#!" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $current->name; ?></a>
    <div style="min-width: auto;" class="dropdown-menu" aria-labelledby="navbarDropdown">
        <?php foreach ($langs as $lang) : ?>

            <?= Html::a($lang->name, /*.'/ru'*/  '/'.$lang->url . Yii::$app->getRequest()->getLangUrl(), ['class' => 'dropdown-item']) ?>
        <?php endforeach; ?>
    </div>
</div>