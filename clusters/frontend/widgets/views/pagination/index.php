<?php
$begin = $pages->page * $pages->pageSize + 1;
$end = $begin + $count - 1;

if ($begin > $end) {
    $begin = $end;
}

$selected_per_page = Yii::$app->request->get("per-page");

?>
<?php if ($pages->pageCount > 1) : ?>
    <div class="row align-items-center mb-30">
        <div class="col-auto">
            <div class="page-showed">
                <?= t('Показано: <b>{begin, number}-{end, number}</b> из <span>{totalCount, number}</span>', [
                    'totalCount' => $pages->totalCount,
                    'begin' => $begin,
                    'end' => $end
                ]) ?>
            </div>
        </div>
        <div class="col">
            <nav aria-label="page-navigation">
                <ul class="pagination mb-0 justify-content-center">
                    <li class="page-item">
                        <a class="page-link" <?= $pages->page == 0 ? 'role="button" disabled' : 'href="' . modify_url_query($_SERVER["REQUEST_URI"], ['page' => $pages->page > 0 ? $pages->page - 1 + 1 : 1]) . '"' ?> aria-label="Previous">
                            <i class="icon-chevron-left"></i>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $pages->pageCount; $i++) : ?>
                        <?php if ($pages->page + 1 == $i) : ?>
                            <li class="page-item active">
                                <span class="page-link rounded-circle"><?= $i ?><span class="sr-only">(current)</span></span>
                            </li>
                        <?php else : ?>
                            <li class="page-item ">
                                <a class="page-link" href="<?= modify_url_query($_SERVER["REQUEST_URI"], ['page' => $i]) ?>"><?= $i ?></a>
                            </li>
                        <?php endif ?>
                    <?php endfor ?>

                    <li class="page-item">
                        <a class="page-link" <?= $pages->page == $pages->pageCount - 1 ? 'role="button" disabled' : 'href="' . modify_url_query($_SERVER["REQUEST_URI"], ['page' => $pages->page + 1 + 1]) . '"' ?> aria-label="Next"><i class="icon-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col-auto">
            <div class="page-show d-flex align-items-center">
                <div class="sorted-by__title mr-10">Показать:</div>
                <select class="form-control sorted-by__select change-pagesize">
                    <option <?=$selected_per_page == $pages->defaultPageSize * 1 ? 'selected' : ''?>><?= $pages->defaultPageSize * 1 ?></option>
                    <option <?=$selected_per_page == $pages->defaultPageSize * 2 ? 'selected' : ''?>><?= $pages->defaultPageSize * 2 ?></option>
                    <option <?=$selected_per_page == $pages->defaultPageSize * 3 ? 'selected' : ''?>><?= $pages->defaultPageSize * 3 ?></option>
                </select>
            </div>
        </div>
    </div>
<?php endif ?>

<?php
$this->registerJs('
    function updateQueryStringParameter(uri, key, value) {
        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = uri.indexOf("?") !== -1 ? "&" : "?";

        if (uri.match(re)) {
            return uri.replace(re, "$1" + key + "=" + value + "$2");
        } else {
            return uri + separator + key + "=" + value;
        }
    }

    $(".change-pagesize").change(function (e){
        window.location.href = updateQueryStringParameter(window.location.href, "' . $pages->pageSizeParam . '", e.target.value);
    });
    $(".change-page").change(function (e){
        window.location.href = updateQueryStringParameter(window.location.href, "' . $pages->pageParam . '", e.target.value);
    });
', 3);
?>