<!-- <div class="container mt-25">
    <?php foreach (\Yii::$app->session->getAllFlashes() as $class => $value) : ?>
        <div class="alert alert-dismissible  alert-<?= $class ?>">
            <?= $value ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endforeach ?>
</div> -->
<!-- 
<?php foreach (\Yii::$app->session->getAllFlashes() as $class => $value) : ?>
    <div class="modal" id="alert-modal-<?= $class ?>" tabindex="-1" style="display: block" role="dialog" aria-labelledby="alert-modal-<?= $class ?>">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            <img src="/img/close-alert.svg" alt="">
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center">
                        <?php if ($class == "success") : ?>
                            <img src="/img/success-alert.svg" alt="">
                        <?php elseif ($class == "danger") : ?>
                            <img src="/img/danger-alert.svg" alt="">
                        <?php endif ?>
                    </p>
                    <p class="alert-title">
                        <?= t("Успешно!") ?>
                    </p>
                    <p class="alert-description">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Perferendis nam cumque dicta repudiandae laborum rem temporibus ea, culpa, in corporis architecto, error delectus quibusdam magnam numquam aperiam corrupti suscipit! Natus!
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?> -->

<?php
foreach (\Yii::$app->session->getAllFlashes() as $class => $value) :
    $this->registerJs('
        toastr["' . ($class == "danger" ? "error" : $class) . '"]("' . $value . '");
    ', 3);
endforeach;
