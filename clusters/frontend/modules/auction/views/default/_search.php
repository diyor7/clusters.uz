<div class="row mx-0">
    <?php foreach ($models as $model) : ?>
        <div class="col-md-6 mb-4">
            <button type="button" class="btn btn-default text-left select-tovar" data-tovar_id="<?= $model->id ?>">
                <i class="icon_plus"></i> <?= $model->title ?>
            </button>
        </div>
    <?php endforeach ?>
</div>