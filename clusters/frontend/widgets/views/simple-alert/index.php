<div class="container mt-25">
    <?php foreach (\Yii::$app->session->getAllFlashes() as $class => $value) : ?>
        <div class="alert alert-dismissible  alert-<?= $class ?>">
            <?= $value ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endforeach ?>
</div>
