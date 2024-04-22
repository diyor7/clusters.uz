<?php

use chillerlan\QRCode\QRCode;
use common\models\Company;
use common\models\Order;
use common\models\Product;
use yii\helpers\ArrayHelper;

function tab()
{
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}
?>

<style>
    * {
        font-family: 'DejaVu Sans', 'sans-serif';
        font-size: 12px;
        color: #333333;
    }

    .fwb {
        font-weight: bold;
    }

    .text-center {
        text-align: center;
    }

    .float-left {
        float: left;
    }

    .float-right {
        float: right;
    }

    .text-left {
        text-align: left;
    }

    .text-right {
        text-align: right;
    }

    .clearfix {
        clear: both;
    }

    .underline {
        text-decoration: underline;
    }

    .text {
        text-align: justify;
        font-size: 12px;
    }

    .mt-15 {
        margin-top: 15px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .my-10 {
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .my-15 {
        margin-top: 15px;
        margin-bottom: 15px;
    }

    .pl-10 {
        padding-left: 10px;
        text-align: justify;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
        text-align: center;
    }

    .p-5 {
        padding: 5px;
    }

    .p-10 {
        padding: 10px;
    }
</style>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<p class="fwb text-center">
    ДОГОВОР № <?= $model->id ?> <br> 
    на поставку товаров по результатам проведения электронных государственных закупок на 
    специальном информационном портале (Аукцион) от <?= date("d.m.Y", strtotime($model->created_at)) ?> год время <?= date("H:i:s", strtotime($model->created_at)) ?> (лот № <?= $model->id ?>)
</p>

<p class="float-left text-left mt-10">
    <span class="underline">г. Ташкент</span>
    <br>
    (место заключения договора)
</p>
<p class="float-right text-right mt-10">
    «<?= date("d", strtotime($model->created_at)) ?>» <?= date("m", strtotime($model->created_at)) ?> <?= date("Y", strtotime($model->created_at)) ?> г.
    <br>
    (дата заключения договора)
</p>
<div class="clearfix"></div>

<p class="text mt-10">
    <?= $model->customer->name ?>, являющийся
    корпоративным заказчиком, именуемый в дальнейшем <span class="fwb">«Заказчик»</span>, в лице
    ________________________________, действующий на основании _____________, с одной стороны и <?= $model->producer->name ?>
    именуемый дальнейшем <span class="fwb">«Исполнитель»</span>, в лице _______________________, действующий на основании ________________, с
    другой стороны, совместно именуемые <span class="fwb">«Стороны»</span>, по результатам проведения электронных государственных
    закупок на специальном информационном портале, заключили настоящий договор о нижеследующем.

</p>

<p class="title text-center fwb my-10">
    1. ПРЕДМЕТ ДОГОВОРА
</p>

<p class="pl-10"><?= tab() ?> 1.1. По настоящему договору Заказчик оплачивает и принимает, а Исполнитель поставляет товар на следующих условиях: </p>
<table>
    <thead>
        <tr>
            <th>№</th>
            <th>Товар</th>
            <th class="text-center">№ ЛОТА</th>
            <th class="text-center">Количество товара</th>
            <th class="text-center">Предложенная цена</th>
            <th class="text-right">Сумма</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($model->auction->auctionCategories as $index => $auctionCategory) : ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $auctionCategory->category->title ?></td>
                <td class="text-center"><?= $model->auction_id ?></td>
                <td class="text-center"><?= showQuantity($auctionCategory->quantity) ?> <?= $auctionCategory->unit->title ?></td>
                <td class="text-center"><?= showPrice($auctionCategory->price * ($model->auction->currentPrice / $model->auction->total_sum)) ?> сум</td>
                <td class="text-right"><?= showPrice($model->auction->currentPrice) ?> сум</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p class="pl-10 my-15"><?= tab() ?> Общая сумма договора составляет <?= showPrice($model->auction->currentPrice) ?> сум </p>

<p class="pl-10 mt-15"><?= tab() ?> Подробное описание товара: </p>

<table>
    <tbody>
        <?php foreach ($model->auction->auctionCategories as $index => $auctionCategory) : ?>
            <tr>
                <td><?= $auctionCategory->category->title ?></td>
                <td><?= $auctionCategory->description ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php if (count($model->auction->auctionConditions) > 0) : ?>
    <p class="pl-10 mt-15"> <b> Особые условия : </b> </p>
    <?php $i = 1;
        foreach ($model->auction->auctionConditions as $auctionCondition) :
            $cat_name = $auctionCondition->texts;
            foreach (json_decode($auctionCondition->inputs) as $x){
                if(is_array($x)){
                    $x = $x[0];
                }
                $cat_name = preg_replace("/:X/", $x, $cat_name, 1 );
            }
    ?>
    <p class="pl-10 mt-15">
        <?= $i++ . ' ' . $cat_name ?>
    </p>
    <?php endforeach ?>
<?php endif ?>


<p class="title text-center fwb my-10">
    2. ПОРЯДОК ОПЛАТЫ, СРОКИ И УСЛОВИЯ ПОСТАВКИ
</p>
<p class="pl-10 my-15"><?= tab() ?> 2.1. Заказчик обязуется обеспечить наличие на лицевом счете в расчетно-клиринговой палате Оператора (далее –
    РКП) 100% суммы договора, в течении 5 рабочих дней. При этом, задаток засчитывается в счет суммы договора. 
</p>
<p class="pl-10 my-15"><?= tab() ?> 2.2. Исполнитель обязуется осуществить поставку товара в течение 7 рабочих дней с момента получения
    уведомления от расчетно-клиринговой палаты Оператора (далее – РКП) об оплате. 
</p>
<p class="pl-10 my-15"><?= tab() ?> 2.3. Заказчик обязан проверить комплектность, качество и соответствие другим требованиям предусмотренные в
    заявке (оферте) о проведении электронных государственных закупок получаемого товара в присутствии
    Исполнителя при принятии товара. 
</p>
<p class="pl-10 my-15"><?= tab() ?> 2.4. Все расходы по транспортировке товара несет Исполнитель, если иное не установлено условиями настоящего
    договора. 
</p>
<p class="pl-10 my-15"><?= tab() ?> 2.5. После принятия товара в течение 3 рабочих дней Заказчик обязан направить информацию Оператору,
    подтверждающую поставку товара, через свой персональный кабинет, на основании которой в установленном
    порядке осуществляется оплата на расчетный счет Исполнителя. 
</p>


<p class="title text-center fwb my-10">
    3. ПРАВА И ОБЯЗАННОСТИ СТОРОН
</p>


<p class='pl-10 my-15'> 3.1. Права Заказчика: требовать от Исполнителя поставки товара в количестве и качестве, предусмотренном
пунктом 1 настоящего договора; при поставке товара ненадлежащего качества по своему выбору требовать от
Исполнителя: замены на аналогичный товар надлежащего качества; безвозмездного устранения недостатков;
возмещения нанесенного ущерба в результате неисполнения или ненадлежащего исполнения условий настоящего
договора. </p>
<p class='pl-10 my-15'> 3.2. Обязанности Заказчика: обеспечить наличие на лицевом счете оператора в Казначействе Министерстве
финансов Республики Узбекистан денежные средства в размере 100% суммы договора, в срок, установленный
настоящим договором. согласовать с Исполнителем через свой персональный кабинет время и дату поставки и приемки товаров. принять поставленные по его объявлению (заявке) товары в соответствии с настоящим
договором. в согласованные сроки. после принятия товара своевременно направить информацию Оператору,
подтверждающую поставку товара.</p>
<p class='pl-10 my-15'> 3.3. Исполнитель вправе: требовать от Заказчика возмещения нанесенного ущерба, в результате необоснованного
отказа от принятия поставленных товаров в соответствии с поданной заявкой. </p>
<p class='pl-10 my-15'> 3.4. Исполнитель обязан: поставлять Заказчику товары в сроки, в количестве и качестве в соответствии с настоящим
договором. согласовать с Заказчиком через свой персональный кабинет время и дату поставки товаров по
требованию Заказчика в срок поставки, установленный настоящем договором, безвозмездно исправить все
выявленные недостатки в процессе поставки товара. </p>
<p class='pl-10 my-15'> 3.5. Договор должен исполняться надлежащим образом в соответствии с условиями и требованиями настоящего
договора и законодательства Республики Узбекистан. </p>
<p class='pl-10 my-15'> 3.6. Договор считается исполненным в том случае, если Стороны обеспечили исполнение всех принятых на себя
обязательств. </p>


<p class="title text-center fwb my-10">
    4. ОТВЕТСТВЕННОСТЬ СТОРОН
</p>

<p class="pl-10 my-15"><?= tab() ?> 4.1. Заказчик и Исполнитель несут ответственность за неисполнения и нарушения условий настоящего договора в
соответствии с законодательством. </p>
<p class="pl-10 my-15"><?= tab() ?> 4.2. Стороны освобождаются от ответственности за частичное или полное невыполнение обязательств по
настоящему договору, если это невыполнение явилось следствием форс-мажорных обстоятельств, делающих
невозможным выполнение настоящего договора при наличии условий, предусмотренных законодательством. </p>

<p class="title text-center fwb my-10">
    5. ПОРЯДОК РАЗРЕШЕНИЯ СПОРОВ
</p>

<p class="pl-10 my-15"><?= tab() ?> 5.1. При возникновении споров и разногласий, стороны принимают меры по их досудебному разрешению. </p>

<p class="pl-10 my-15"><?= tab() ?> 5.2. Стороны вправе за разрешением разногласий и споров обратиться непосредственно в суд по месту нахождению истца. </p>

<p class="pl-10 my-15"><?= tab() ?> 5.3. Взаимоотношения сторон, не оговоренные в настоящем договоре, регулируются законодательством
Республики Узбекистан. </p>

<p class="title text-center fwb my-10">
    6. СРОК ДЕЙСТВИЯ КОНТРАКТА
</p>

<p class="pl-10 my-15"><?= tab() ?> 6.1. Настоящий договор вступает в силу с момента заключения настоящего договора в установленном порядке и
действует до "31" декабря 20__ г. </p>

<p class="pl-10 my-15"><?= tab() ?> 6.2. Истечение срока действия договора не освобождает стороны от ответственности. </p>

<p class="title text-center fwb my-10">
    7. ЮРИДИЧЕСКИЕ АДРЕСА И РЕКВИЗИТЫ СТОРОН
</p>

<table>
    <tbody>
        <tr>
            <td>
                <b>Исполнитель</b>
                <br>
                Наименование: <?= $model->producer->name ?>
                <br>
                Адрес: <?= $model->producer->address ?>
                <br>
                Тел.: <?= $model->producer->phone ?>
                <br>
                e-mail: <?= $model->producer->email ?>
                <br>
                ИНН: <?= $model->producer->tin ?>
                <br>
                Р/С: <?= $model->producer->companyBankAccount->account ?>
                <br>
                Банк: <?= $model->producer->companyBankAccount->bank->name ?>
                <br>
                МФО: <?= $model->producer->companyBankAccount->mfo ?>
                <br>
                Договор заключен с использованием ЭЦП.
                <br><br><br><br><br><br><br><br>
            </td>
            <td></td>
            <td>
                <b>Заказчик</b>
                <br>
                Наименование: <?= $model->customer->name ?>
                <br>
                Адрес: <?= $model->customer->address ?>
                <br>
                Тел.: <?= $model->customer->phone ?>
                <br>
                e-mail: <?= $model->customer->email ?>
                <br>
                ИНН: <?= $model->customer->tin ?>
                <br>
                Р/С: <?= $model->customer->companyBankAccount->account ?>
                <br>
                Банк: <?= $model->customer->companyBankAccount->bank->name ?>
                <br>
                МФО: <?= $model->customer->companyBankAccount->mfo ?>
                <br><br><br><br><br><br><br><br>
            </td>
        </tr>
    </tbody>
</table>

<table class="mt-15 text-left">
    <tbody>
        <tr>
            <td class="text-left p-10">
                <b>Реквизиты Оператора для оплаты по договору</b>
                <br>
                ИНН: 307442330
                <br>
                Банк МФО 00419, "Ипотека-Банк"
                <br>
                Расчетный счет: 20210000805235588100
            </td>
        </tr>
    </tbody>
</table>

<div class="text-center">
    <?php
    $data = 'http://clusters.uz' . toRoute('/cabinet/contract/pdf/' . $model->id);
    echo '<img src="' . (new QRCode())->render($data) . '" alt="QR Code" />';
    ?>
</div>

<script type='text/php'>
    $font = $fontMetrics->get_font('DejaVu Sans', 'normal');
    $size = 10;
</script>