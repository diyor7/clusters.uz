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
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=1350">
    <meta name="format-detection" content="telephone=no">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JL4132CJ69"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-JL4132CJ69');
    </script>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <div class="new-home-page">

        <?= $this->render("_header") ?>

        <?= \frontend\widgets\MyAlert::widget() ?>

        <?= $content ?>

        <?= $this->render('_footer') ?>
    </div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>