<?php

use common\models\Page;
use common\models\Region;
use common\models\RequestCluster;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$model = Page::findOne(40);
?>

<div class="modal" id="requestClusterModal2">
    <div class="modal-dialog request-modal modal-lg modal-dialog-centered">
        <div class="modal-body bg-white">

            <div class="bg-white">
                <div class="container py-30">
                    <div class="d-flex align-items-around mb-25" style="justify-content: space-between;">
                        <div>
                            <h1 class="new-title-4 mb-0 pt-2">
                                <?= t("Конференция") ?>
                            </h1>
                        </div>
                        <div class="">
                            <a class="btn btn-success text-white" href="<?=toRoute(['/page/forum'])?>"><?=t("Участие в конференции")?></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="new-bg-different">
                <div class="container py-40">
                    <?= $model->description ?>
                </div>
            </div>
        </div>
    </div>
</div>