<?php foreach ($models as $model) : ?>
    <div class="mb-4">
        <button type="button" class="btn btn-info text-left select-tn" data-tn="<?=$model->id?>">
            <i class="icon_plus"></i> <?= $model->title ?>
        </button>
    </div>
<?php endforeach ?>