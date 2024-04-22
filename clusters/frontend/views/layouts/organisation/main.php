<?php

use common\models\Order;
use frontend\assets\AppAsset;
use frontend\assets\AppAssetEcp;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
AppAssetEcp::register($this);

Yii::$app->language = Yii::$app->languageId->url ? Yii::$app->languageId->url : 'ru';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?= siteUrl() . 'img/logo-alt.svg' ?>" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <meta name="format-detection" content="telephone=no">
    <?php $this->head() ?>
</head>

<body class="front-page">
    <?php $this->beginBody() ?>

    <?= $this->render("_header") ?>

    <?= \frontend\widgets\MyAlert::widget() ?>

    <?= $content ?>

    <?= $this->render('_footer') ?>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>