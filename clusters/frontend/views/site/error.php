<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="container p-40" style="min-height: 50vh">
    <h1 class="text-danger"><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p> 
        <?= Yii::t('app', 'The above error occurred while the Web server was processing your request.') ?>
    </p>
    <p>
        <?= Yii::t('app', 'Please contact us if you think this is a server error. Thank you.') ?>
    </p>

</div>
