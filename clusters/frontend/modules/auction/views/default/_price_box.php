<div class="label mt-30">
    <?=t("Кол-во участников")?>
</div>
<div class="value">
    <?= $auctionRequests ?>
</div>
<div class="label mt-30">
    <?=t("Стартовая сумма")?>
</div>
<div class="value">
    <?= showPrice($total_sum) ?> <?= t("сум") ?>
</div>
<div class="label mt-30">
    <?=t("Текущая сумма")?>
</div>
<div class="value">
    <?php if ($total_sum === $currentPrice) : ?>
        <?= t("Пока не подана") ?>
    <?php else : ?>
        <?= showPrice($currentPrice) ?> <?= t("сум") ?>
    <?php endif ?>
</div>
<div class="label mt-30">
    <?=t("Следующая цена")?>
</div>
<div class="value">
    <?= showPrice($nextPrice) ?> <?= t("сум") ?>
</div>
