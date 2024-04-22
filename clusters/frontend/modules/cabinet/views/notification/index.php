<?php
$this->title = t("Уведомления");

$this->params['breadcrumbs'][] = array(
    'label' => t("Личный кабинет"),
    'url' => toRoute('/cabinet')
);
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render("../layouts/_nav") ?>

<div class="new-bg-different py-30">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?= $this->render("../layouts/_menu") ?>
            </div>
            <div class="col-md-9">
                <div class="cabinet__content" id="fullscreenme">
                    <p class="mt-25 empty-notifications" <?= count($notifications) > 0 ? 'style="display: none"' : '' ?>><?= t("Пока никаких уведомлений нет.") ?></p>

                    <div class="row cabinet__content_notice">
                        <?php foreach ($notifications as $notification) : ?>
                            <div class="col-lg-6 px-25 pt-20 pb-25 position-relative mt-15">
                                <p class="font-family-monsterrat gray-text-dark font-weight-bolder mb-10 float-left"><?= $notification->text ?></p>
                                <a class="position-absolute delete_notification cursor-pointer" role="button" data-id="<?= $notification->id ?>">
                                    <i class="icon_close"></i>
                                </a>
                                <div class="clearfix"></div><span class="d-block font-family-roboto gray-text-darker fs-14"><?= $notification->date ?></span>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->registerJs('
$(".delete_notification").click(function(){
    var id = $(this).data("id");
    var _this = this;

    $.ajax({
        url: "' . toRoute('/cabinet/notification/delete?id=') . '" + id,
        method: "POST"
    }).done(function (res){
        if (res.status == "success"){
            toastr.success(res.message);  
            $(_this).parent().remove();
            
            if ($(_this).parent().parent().children().length == 0){
                $(".empty-notifications").show();
            }
        }
    });
});

', \yii\web\View::POS_END); ?>