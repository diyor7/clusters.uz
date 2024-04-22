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
    Давлат харидлари электрон тизимида <?= date("d.m.Y", strtotime($model->created_at)) ?> йилда соат <?= date("H:i:s", strtotime($model->created_at)) ?> да (лот № <?= $model->id ?>)
    ўтказилган электрон давлат харидлари натижаси бўйича товар етказиб бериш тўғрисида ШАРТНОМА № <?= $model->id ?>
</p>

<p class="float-left text-left mt-10">
    <span class="underline">Тошкент ш.</span>
    <br>
    (шартнома тузилган жой)
</p>
<p class="float-right text-right mt-10">
    «<?= date("d", strtotime($model->created_at)) ?>» <?= date("m", strtotime($model->created_at)) ?> <?= date("Y", strtotime($model->created_at)) ?> й.
    <br>
    (шартнома тузилган сана)
</p>
<div class="clearfix"></div>

<p class="text mt-10">
    Корпоратив буюртмачи бўлган кейинги ўринларда <span class="fwb">“Буюртмачи”</span> деб аталувчи <?= $model->customer->name ?> номидан__________________асосида иш юритувчи
    ____________________________ бир тарафдан ва кейинги ўринларда <span class="fwb">“Ижрочи”</span> деб аталувчи <?= $model->producer->name ?> номидан__________________асосида
    иш юритувчи ____________________________ иккинчи тарафдан, биргаликда <span class="fwb">«Тарафлар»</span> деб аталувчилар Давлат харидлари электрон тизимида ўтказилган электрон
    давлат хариди натижаси бўйича қуйидагича шартнома туздилар.
</p>
<p class="title text-center fwb my-10">
    1. ШАРТНОМА ПРЕДМЕТИ
</p>
<p class="pl-10"><?= tab() ?> 1. Буюртмачи товар учун жами тўловни амалга оширади ва товарни қабул қилиб олади, Ижрочи товарни қуйидаги шартларда етказиб беради
</p>
<table>
    <thead>
        <tr>
            <th>№</th>
            <th>Товар номи</th>
            <th>Категория</th>
            <th>Сони</th>
            <th>Бирлик учун бошланғич нарх</th>
            <th>Товар бирлиги учун келишилган нарх</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($model->order->orderLists as $index => $orderList) : ?>
            <tr>
                <td><?= $index + 1; ?></td>
                <td><?= $orderList->cacheProduct['name'] ?></td>
                <td><?= $orderList->cacheProduct['category_name'] ?></td>
                <td><?= $orderList->quantity ?></td>
                <td><?= showPrice($model->order->winner->price) ?> сум</td>
                <td><?= showPrice($orderList->quantity * $model->order->winner->price) ?> сум</td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<p class="pl-10 mt-15"><?= tab() ?> Шартноманинг умумий суммаси _______________________________________ҚҚС билан (ҚҚС сиз*) </p>
<p class="pl-10 mt-15"> _________________________________________________________ сўмни ташкил этади. </p>
<p class="text-center mt-10">
    <span class="underline">*__________________________________________________________________________________</span>
    <br>
    (ҚҚС тўланмаслик асоси)
</p>

<table>
    <tbody>
        <?php foreach ($model->order->orderLists as $index => $orderList) : ?>
            <tr>
                <td>Техник параметрлар </td>
                <td><?= $orderList->cacheProduct['description'] ?></td>
            </tr>

            <?php foreach ($orderList->cacheProperties as $props) : ?>
                <tr>
                    <td><?= $props['property'] ?></td>
                    <td><?= $props['value'] ?> <?= $props['count_unit'] ?></td>
                </tr>
            <?php endforeach ?>

            <!-- <tr>
                    <td>
                        Срок доставки
                    </td>
                    <td>
                        <?php
                        // if (!$orderList->cacheProduct['delivery_period'])
                        //     echo "";
                        // else if ($orderList->cacheProduct['delivery_period_type'] == Product::DELIVERY_PERIOD_TYPE_DAY)
                        //     echo plural($orderList->cacheProduct['delivery_period'], t("день"), t("дня"), t("дней"));
                        // else if ($orderList->cacheProduct['delivery_period_type'] == Product::DELIVERY_PERIOD_TYPE_MONTH) {
                        //     echo plural($orderList->cacheProduct['delivery_period'], t("месяц"), t("месяца"), t("месяцев"));
                        // } else {
                        //     echo plural($orderList->cacheProduct['delivery_period'], t("год"), t("года"), t("лет"));
                        // }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Тип доставки
                    </td>
                    <td>
                        <?php
                        // echo array_key_exists($orderList->cacheProduct['delivery_type'], Order::getDeliveryTypes()) ? Order::getDeliveryTypes()[$orderList->cacheProduct['delivery_type']] : ""
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Место доставки товаров
                    </td>
                    <td>
                        <?php
                        //echo count($orderList->product->productDeliveryRegions) > 0 ? join(", ", ArrayHelper::getColumn($orderList->product->productDeliveryRegions, 'region.title')) : t("Нет")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Гарантийное и техническое обслуживание</td>
                    <td>
                        <?php
                        // if (!$orderList->cacheProduct['warranty_period']) echo "";
                        // else if ($orderList->cacheProduct['warranty_period_type'] == Product::WARRANTY_PERIOD_TYPE_DAY)
                        //     echo plural($orderList->cacheProduct['warranty_period'], t("день"), t("дня"), t("дней"));
                        // else if ($orderList->cacheProduct['warranty_period_type'] == Product::WARRANTY_PERIOD_TYPE_MONTH) {
                        //     echo plural($orderList->cacheProduct['warranty_period'], t("месяц"), t("месяца"), t("месяцев"));
                        // } else {
                        //     echo plural($orderList->cacheProduct['warranty_period'], t("год"), t("года"), t("лет"));
                        // }
                        ?>
                    </td>
                </tr> -->
            <tr>
                <td colspan="2"></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<p class="title text-center fwb my-10">
    2. ТЎЛОВ ТАРТИБИ, ЕТКАЗИБ БЕРИШ МУДДАТИ ВА ШАРТЛАРИ
</p>


<p class="pl-10 my-15"><?= tab() ?> 2.1. Буюртмачи шартнома суммасининг 100% миқдорида тўловни Операторнинг Ҳисоб-китоб клиринг палатасидаги (ҲККП) ҳисобрақамига 10 иш куни ичида ўтказади. Бунда киритилган закалат суммаси битимнинг умумий суммаси ҳисобига киритилади.</p>
<p class="pl-10 my-15"><?= tab() ?> 2.2. Ижрочи тўлов амалга оширилганлиги тўғрисида ҲККП дан хабарнома олганидан бошлаб_______ иш куни ичида товарни етказиб бериши шарт. </p>
<p class="pl-10 my-15"><?= tab() ?> 2.3. Буюртмачи товарнинг сони тўлиқлигини, бутлигини, сифатини ва эълонда ёки офёртада кўрсатилган бошқа талабларга мувофиқлигини Ижрочининг иштирокида текшириб қабул қилиб олиши шарт. </p>
<p class="pl-10 my-15"><?= tab() ?> 2.4. Барча транспорт харажатлари Ижрочи томонидан қопланади (агар мазкур шартномада бошқа шартлар белгиланмаган бўлса). </p>
<p class="pl-10 my-15"><?= tab() ?> 2.5. Ижрочи томонидан товарни етказиб берилганлиги ва Буюртмачи томонидан текшириб олинганлиги Ижрочи расмийлаштирган ҳисобварақ-фактурани Тарафлар томонидан имзоланиши билан тасдиқланади. </p>
<p class="pl-10 my-15"><?= tab() ?> 2.6. Буюртмачи товарни қабул қилиб олгандан бошлаб уч иш куни ичида бу ҳақида ўз шахсий кабинети орқали Операторга хабарнома юбориши лозим. Буюртмачи шахсий кабинетидан Операторга юборилган хабар асосида тўлов маблағи белгиланган тартибда Ижрочининг ҳисобрақамига ўтказилади.</p>

<p class="title text-center fwb my-10">
    3. ТАРАФЛАРНИНГ ҲУҚУҚ ВА МАЖБУРИЯТЛАРИ 
</p>

<p class="pl-10 my-15"><?= tab() ?> 3.1. Буюртмачи қуйидаги ҳуқуқларга эга: </p>
<p class="pl-10 my-15"><?= tab() ?> Ижрочидан  мазкур шартноманинг 1 бандига мувофиқ бўлган миқдордаги ва сифатдаги товарни етказиб беришни талаб қилиш;  </p>
<p class="pl-10 my-15"><?= tab() ?> Ижрочи  талаб  даражасидаги сифатга эга бўлмаган товар етказиб берганда Ижрочидан қуйидагиларни талаб қилишга ҳақли: </p>
<p class="pl-10 my-15"><?= tab() ?> -талаб даражасидаги сифатли товарга алиштириб беришни; </p>
<p class="pl-10 my-15"><?= tab() ?> -етказиб берилган  товардаги камчиликларни Ижрочи ҳисобидан бартараф этилишини; </p>
<p class="pl-10 my-15"><?= tab() ?> -мазкур шартнома шартларини бажармаганлик ёки белгиланган даражада бажармаганлик натижасида етказилган зарарни қоплашни.  </p>

<p class="pl-10 my-15"><?= tab() ?> 3.2. Буюртмачининг мажбуриятлари қуйидагилардан иборат: </p>
<p class="pl-10 my-15"><?= tab() ?> Шартнома суммасининг 100% миқдоридаги тўловни  мазкур шартномада кўрсатилган муддатда ҲККП даги ҳисобрақамига ўтказиши лозим; товарни етказиш ва қабул қилиб олиш саналарини Ижрочи билан шахсий кабинет орқали  хабарлашиб келишиб 
олиш;
</p>
<p class="pl-10 my-15"><?= tab() ?> Давлат харидлари электрон тизимида жойлаштирган эълони (талаби) бўйича етказиб берилган товарни мазкур шартномада кўрсатилган муддатларда қабул қилиб олиш. </p>
<p class="pl-10 my-15"><?= tab() ?> товар қабул қилиб олинганлиги тўғрисидаги хабарни белгиланган муддатда Операторга юбориш. </p>

<p class="pl-10 my-15"><?= tab() ?> 3.3. Ижрочининг мажбуриятлари қуйидагилардан иборат: </p>
<p class="pl-10 my-15"><?= tab() ?> Буюртмачи билан келишган ҳолда товарни муддатидан олдин етказиб бериш;  </p>
<p class="pl-10 my-15"><?= tab() ?> Буюртмачининг ўзи томонидан берилган талабномага мос бўлган товарни қабул қилиб олишни рад этиши натижасида етказилган зарарни қоплашни талаб қилиш. </p>

<p class="pl-10 my-15"><?= tab() ?> 3.4. Ижрочининг мажбуриятлари қуйидагилардан иборат: </p>
<p class="pl-10 my-15"><?= tab() ?> Буюртмачига товарни мазкур шартномага мувофиқ  сифат ва миқдорда  ва белгиланган  саналарда етказиб бериш;  товарни етказиб бериш  санаси ва вақтини шахсий кабинет орқали Буюртмачи билан келишиб олиш; товарни етказиб бериш жараёнида аниқланган камчиликларни Буюртмачининг талабига кўра етказиб 
беришнинг белгиланган муддатигача бартараф этиш.
 </p>
 
<p class="pl-10 my-15"><?= tab() ?>3.5. Шартнома шартлари Ўзбекистон Республикаси  қонунчилигига ва мазкур шартнома талабларига мувофиқ ижро этилиши лозим. </p>
<p class="pl-10 my-15"><?= tab() ?> 3.6. Тарафлар ўз мажбуриятларини тўлиқ бажарилишини таъминлаганларида  Шартнома бажарилган деб ҳисобланади. </p>
<p class="pl-10 my-15"><?= tab() ?> 3.7. Тарафлар шартнома бўйича ўз мажбуриятларини бажараётганда Ўзбекистон Республикасининг коррупцияга қарши курашиш 
тўғрисидаги қонунчилик ҳужжатларининг талабларига зид келадиган ҳар қандай ҳаракатларни амалга оширмайдилар, шу жумладан пора, яъни (давлат органи ёки ташкилотининг) 
ходими ўз хизмат мажбуриятларидан фойдаланган ҳолда пора берган шахснинг манфаатларини кўзлаб муайян ҳаракатларни содир этиши ёки содир этмаслиги шартлиги ёҳуд мумкинлиги 
учун моддий қимматликларни ёки мулкий наф олиш учун қуйидаги ҳаракатларни қилмайди: пора беришни таклиф қилиш ёки ваъда бериш;  товламачилик қилиш;  пора сифатида пул тўлаш; бевосита ёки билвосита пора олишга розилик бериш. </p>
<p class="pl-10 my-15"><?= tab() ?> Тарафлар ушбу ҳаракатларга йўл қўймаслик бўйича чоралар кўрилишига кафолат беради.  </p>
<p class="pl-10 my-15"><?= tab() ?> 3.8. Aгар шартнома бўйича бир тараф (давлат органи ёки ташкилотининг) ходимининг ахлоққа тўғри келмайдиган ва ушбу шартнома ёки Ўзбекистон Республикаси 
қонунчилик ҳужжатларига зид келадиган хаттиҳаракатларига, шу жумладан, коррупцияга оид ҳуқуқбузарлик содир этишга мажбурлашдан иборат бўлган фактларга дуч келса, бу ҳақда қуйидаги алоқа каналларидан 
бири орқали хабардор қилиши керак:  <br>
+998 71 207 66 65 телефон рақами;  <br>
info@idm.uz электрон почта. 
 </p>
<p class="title text-center fwb my-10">
    4. ТАРАФЛАРНИНГ ЖАВОБГАРЛИГИ 
</p>

<p class="pl-10 my-15"><?= tab() ?> 4.1. Буюртмачи ва Ижрочи мазкур Шартнома шартларини бажармаганлик ва бузганлик учун қонунчиликда белгиланган тартибда жавобгарликка тортиладилар.  </p>
<p class="pl-10 my-15"><?= tab() ?> 4.2. Тарафлар қонунчиликда белгиланган форс-мажор ҳолатлари  мавжудлиги натижасида   шартномада белгиланган мажбуриятларини  бажариш иложсизлигидан тўлиқ ёки қисман бажара олмаганларида жавобгарликка тортилмайдилар.</p>
<p class="pl-10 my-15"><?= tab() ?> 4.3. Тарафлар закалатни қўллашда, шу жумладан унинг миқдорини белгилашда давлат харидлари тўғрисидаги қонунчилик хужжатларида келтирилган талабларга риоя қилишга ўз розиликларини билдирадилар.  </p>
<p class="pl-10 my-15"><?= tab() ?> 4.4. Товарларни етказиб бериш муддатлари кечиктириб юборилган, тўлиқ етказиб берилмаган ҳолларда, ижрочи буюртмачига кечиктирилган ҳар бир кун учун мажбурият бажарилмаган қисмининг 0,5 фоизи миқдорида пеня тўлайди, бироқ бунда пенянинг умумий суммаси етказиб берилмаган товарлар баҳосининг 50 фоизидан ошиб кетмаслиги лозим.  </p>
<p class="pl-10 my-15"><?= tab() ?> 4.5. Агар етказиб берилган товарлар сифати, ассортименти ва нави бўйича стандартлар, техник шартлар, намуналарга (эталонларга) қонунчиликда ёки шартномада белгиланган 
бошқа мажбурий шартларга мос келмаса, буюртмачи товарларни қабул қилиш ҳамда уларнинг ҳақини тўлашни рад этиб, ижрочидан  сифати, ассортименти ва нави лозим даражада бўлмаган товарлар қийматининг 
20 фоизи миқдорида жарима ундириб олишга, агар товарлар ҳақи тўлаб қўйилган бўлса, тўланган суммани белгиланган тартибда қайтаришни талаб қилишга ҳақлидир. Сифати, ассортименти ва нави лозим даражада 
бўлмаган товарлар етказиб берганлик учун жарима ижрочидан акцептсиз тартибда ундириб олинади.  </p>

<p class="title text-center fwb my-10">
    5. НИЗОЛАРНИ ҲАЛ ЭТИШ ТАРТИБИ 
</p>

<p class="pl-10 my-15"><?= tab() ?> 5.1. Тарафлар юзага келган баҳс ва мунозараларни судгача   ҳал этиш чораларини кўрадилар.</p>

<p class="pl-10 my-15"><?= tab() ?> 5.2. Тарафлар юзага келган мунозараларни ҳал этиш учун даъвогарнинг жойлашган ҳудуди бўйича судга мурожаат қилишлари мумкин. </p>

<p class="pl-10 my-15"><?= tab() ?> 5.3. Тарафлар ўртасидаги мазкур шартномада кўзда тутилмаган муносабатлар Ўзбекистон Республикаси қонунчилигига аосоан тартибга солинади. </p>

<p class="title text-center fwb my-10">
    6. ФОРС-МАЖОР ҲОЛАТЛАРИ 
</p>

<p class="pl-10 my-15"><?= tab() ?> 6.1. Агар ушбу шартнома тузилгандан сўнг, ушбу шартномада белгиланган мажбуриятларнинг бирон бир томонини тўлиқ ёки қисман тўғри бажаришига тўсқинлик қиладиган ҳолатлар юзага келса ва агар бундай ҳолатлар, яъни ёнғин, тошқин, зилзила, бошқа табиий офатлар, экспорт ёки импортга тўсиқлар ёки эмбарголар, уруш, жанговар ҳаракатлар, террористик ҳаракатлар, иш ташлашлар (томонлар ишчиларининг иш ташлашларидан ташқари), пандемия, амалдаги қонунчиликдаги ўзгаришлар, давлат органлари ва Ўзбекистон Республикаси Ҳукумати томонидан қабул қилинган умумий характердаги қарорлар томонларнинг шартнома шартларини бажаришига бевосита таъсир қилса, тегишли мажбуриятларнинг бажарилиши вақти бундай ҳолатлар бартараф этилган вақтга ёки уларнинг оқибатлари тугаши вақтига кўчирилади.</p>

<p class="pl-10 my-15"><?= tab() ?> 6.2. Форс-мажор ҳолатлари юзага келган Томон, ушбу ҳолат ҳақида шунингдек, ҳолатнинг тахминий давомийлиги тўғрисида бошқа Томонни ёзма равишда 7 (етти) кун ичида хабардор қилиши шарт. Агар юқорида кўрсатилган ҳолатлар тўғрисида ўз вақтида хабар берилмаган бўлса, енгиб бўлмас куч таъсирида зарар етказилган Томон ушбу ҳолатларни асос қилиб ололмайди. </p>
<p class="pl-10 my-15"><?= tab() ?> 6.3. Хабарномада кўрсатилган фактлар расмий манбалар томонидан берилган ҳужжатлар билан тасдиқланиши керак, шу жумладан, пресс-релизлар, бироқ улар билан чекланмаслик лозим. Бундай хабарноманинг йўқлиги, шунингдек тегишли далилларнинг йўқлиги ушбу томонни шартнома мажбуриятларини бажаришдан озод қилинишига асос сифатида юқоридаги ҳолатларни келтириш ҳуқуқидан маҳрум қилади. </p>
<p class="pl-10 my-15"><?= tab() ?> 6.4. Фавқулодда вазиятлар юзага келган тақдирда, томонлар зудлик билан ўзаро музокаралар олиб борадилар ва фавқулодда вазиятлар оқибатларини бартараф этиш ёки бартараф этиш мақсадида кўриладиган чоралар тўғрисида келишиб оладилар.</p>
<p class="pl-10 my-15"><?= tab() ?> 6.5. Агар форс-мажор ҳолатлари ёки уларнинг оқибатлари томонларнинг ўз мажбуриятларини бажаришига тўсқинлик қиладиган бўлса, томонларнинг ҳар бири бошқа томонга ушбу шартномани бекор қилишнинг кутилаётган санасидан 10 (ўн) иш куни олдин ёзма равишда хабар юборганидан кейин ушбу шартномани бекор қилиш ҳуқуқига эга. Бундай ҳолда томонларнинг ҳеч бири бошқа томондан форс-мажор ҳолатлари натижасида етказилган зарарни қоплашни талаб қилишга ҳақли эмас. Шунингдек, Бажарувчи бажарилмаган мажбуриятлари учун Буюртмачидан олинган барча тўловларни Буюртмачига қайтаради ва Буюртмачи Бажарувчининг бажарилган барча мажбуриятларини тўлиқ тўлайди.</p>
<p class="title text-center fwb my-10">
    7. КОРРУПЦИЯГА ҚАРШИ ҚЎШИМЧА ШАРТЛАР 
</p>
<p class="pl-10 my-15"><?= tab() ?> 7.1. Тарафлар шартнома тузишда, шартноманинг амал қилиш муддатида ва ушбу муддат тугаганидан сўнг, шартнома билан боғлиқ коррупциявий ҳаракатлар содир қилмасликка келишиб оладилар.</p>
<p class="pl-10 my-15"><?= tab() ?> 7.2. Тарафлар шартномадаги коррупцияга қарши қўшимча шартларда белгиланган коррупциянинг олдини олиш чораларини тан олади ва уларга риоя этилиши бўйича ҳамкорликни таъминлайдилар. </p>
<p class="pl-10 my-15"><?= tab() ?> 7.3. Ҳар бир тараф шартнома тузилган пайтда бевосита ўзи ёки унинг ижроия органлари, мансабдор шахслари ва ходимлари томонидан шартнома билан боғлиқ муносабатлар юзасидан қонунга хилоф равишда пул, моддий қийматликларберилмаганлигини, шартнома тузилиши эвазига норасмий пул ёки бошқа моддий қийматликлар олинишига йўл қўйилмаганлигини, таклиф этилмаганлигини, уларни беришга ваъда қилинмаганлигини, шунингдек моддий ёки ҳар қандай турдааги имтиёз, устунликлар олинмаганлигини (келажакда бу турдаги ҳаракатларни амалга ошириши мумкинлиги ҳақида таассурот қолдирилмаганлигини) кафолатлайди. </p>
<p class="pl-10 my-15"><?= tab() ?> Тарафлар, улар томонидан шартнома доирасида жалб қилинган шахсларнинг (ёрдамчи пудратчи ташкилотлар, агентларва тарафлар назорати остидаги бошқа шахсларнинг) юқоридаги ҳаракатларни содир этмаслиги юзасидан оқилона чоралар кўради. </p>
<p class="pl-10 my-15"><?= tab() ?> 7.4. Тарафлар давлат хизматчилари, сиёсий партиялар, шунингдек ўзларининг ижроия органлари, мансабдор шахслари ва ходимлари томонидан ҳар қандай вақт ва шаклда қуйидааги ҳаракатларни бевосита ёки билвосита (шу жумладан, учинчи шахслар орқали)содир этилишига йўл қўймайди:  </p>
<p class="pl-10 my-15"><?= tab() ?> а) назорат қилувчи органлардан лицензия ва рухсатномалар олиш,солиқ солиш, божхона расмийлаштирувини амалга ошириш, судда иш кўрилиши, қонунчилик жараёни ва бошқа соҳаларда қонунга хилоф равишда тижорат ёки бошқа тусдаги устунликка эга бўлиш ёки сақлаб қолиш мақсадида юқоридаги шахслар фойдасига ёки улар томонидан моддий ёки номоддий наф олишнинг таклиф этилиши, ваъда қилиниши, берилишига;  </p>
<p class="pl-10 my-15"><?= tab() ?> б) қонунга хилоф равишда олинган даромадларнинг легаллаштирилишига,шунингдек, агар мулк жиноий фаолиятдан олинган даромад эканлиги тарафларга маълум бўлса, уни ўтказиш, мулкка айлантириш, ёхуд алмаштириш йўли билан унинг келиб чиқишига қонуний тус бериш, бундай пул маблағлари ёки бошқа мол-мулкнинг асл хусусиятини, манбаини, турган жойини тасарруф этиш, кўчириш усулини, пул маблағларига ёки бошқа мол-мулкка бўлган ҳақиқий эгалик ҳуқуқларини ёки унинг кимга қарашлилигини яширишга; </p>
<p class="pl-10 my-15"><?= tab() ?> в) коррупцияга оид ҳуқуқбузарлик содир қилиш учун таъмагирликқилиш, ундаш, тазйиқ ўтказиш ёки таҳдид қилиш.Ушбу ҳолат бўйича бир тараф иккинчи тарафни ҳамда ваколатли давлат органларини дарҳол хабардор қилиши шарт. </p>
<p class="pl-10 my-15"><?= tab() ?> 7.5. Тарафлар товарлар, ишлар ва хизматларни реализация қилиш ва ўтказишда битимлар тузиш бўйича музокаралар олиб боришда, лицензия, рухсатномалар ва бошқа рухсат этиш хусусиятига эга бўлган ҳужжатларни олишда ёки уларнинг манфаатларини кўзлаб бошқа ҳаракатларни амалга оширувчи тарафларнинг назорати остида бўлган ва улар номидан ҳаракат қиладиган ўахсларга (шу жумладан, ёрдамчи пудратчилар, агентлар, савдо вакиллари, дистрибьюторлар, ҳуқуқшунослар, ҳисобчилар, улар номидан ҳаракат қилувчи бошқа вакилларларга) нисбатан қуйидааги ҳаракатларни амалга оширишлари шарт:  </p>
<p class="pl-10 my-15"><?= tab() ?> - коррупциявий ҳаракатларга йўл қўйиб бўлмаслиги ва коррупциявий ҳаракатларга нисбатан муросасиз муносабатда бўлиши шартлиги ҳақида кўрсатмалар ва тушунтиришлар бериш; </p>
<p class="pl-10 my-15"><?= tab() ?> - улардан коррупциявий ҳаракатларни амалга ошириш учун воситачи сифатида фойдаланмаслик;  </p>
<p class="pl-10 my-15"><?= tab() ?> - уларни фақат тарафларнинг оддий кундаликфаолияти жараёнидаги ишлаб чиқариш зарурати доирасидан келиб чиқиб ишга жалб қилиш;  </p>
<p class="pl-10 my-15"><?= tab() ?> - уларга қонунчилик доирасида амалга оширган хизматлари учун белгиланган ҳақ миқдоридан асоссиз равишда ортиқча тўловларни амалга оширмаслик. </p>
<p class="pl-10 my-15"><?= tab() ?> 7.6. Тарафлар уларнинг назорати остида бўлган ва улар номидан ҳаракат қиладиган шахслар томонидан коррупцияга қарши қўшимча шартларда белгиланган мажбуриятлар бузилганлиги ҳолатлари ҳақида хабар берилганлиги учун уларга тазйиқ ўтказилмаслигини кафолатлайдилар.   </p>
<p class="pl-10 my-15"><?= tab() ?> 7.7. Агар бир тарафга бошқа тарафнинг коррупцияга қарши қўшимча шартларнинг 7.4- ва 7.5-бандларида белгиланган мажбуриятларни бузилишига йўл қўйилганлиги маълум бўлиб қолса, иккинчи тарафни бу ҳақда зудлик билан хабардор қилиши ва ушбу тарафдан оқилона муддат ичида тегишли чоралар кўрилишини ва амалга оширилган ишлар юзасидан унга хабардор қилишини талаб қилиши шарт. </p>
<p class="pl-10 my-15"><?= tab() ?> Тарафнинг талаби бўйича иккинчи тараф томонидан қоидабузарликларни бартараф қилиш бўйича оқилона муддат ичида тегишли чоралар кўрилмаган ёки кўриб чиқиш натижалари ҳақида хабардор қилмаган тақдирда, ушбу тараф шартномани бир тарафлама тўхтатиб туришга, бекор қилишга ҳамда зарарни тўлиқ қоплаб беришни талабқилишга ҳақли. </p>

<p class="title text-center fwb my-10">
    8. ШАРТНОМАНИНГ АМАЛ ҚИЛИШ МУДДАТИ
</p>
<p class="pl-10 my-15"><?= tab() ?> 8.1. Мазкур шартнома  тарафлар томонидан тузилган заҳоти кучга киради ва мажбуриятлар шартномада белгилаб қўйилган шартларда тўлиқ бажарилгунга қадар амал қилади.  </p>
<p class="pl-10 my-15"><?= tab() ?> 8.2. Шартнома муддатининг тугаши тарафларни жавобгарликдан озод этмайди.   </p>
<p class="title text-center fwb my-10">
    9. ТАРАФЛАРНИНГ МАНЗИЛЛАРИ ВА РЕКВИЗИТЛАРИ 
</p>
<table>
    <tbody>
        <tr>
            <td>
                <b>ИЖРОЧИ </b>
                <br>
                Номи: <?= $model->producer->name ?>
                <br>
                Манзили: <?= $model->producer->address ?>
                <br>
                Тел.: <?= $model->producer->phone ?>
                <br>
                e-mail: <?= $model->producer->email ?>
                <br>
                СТИР: <?= $model->producer->tin ?>
                <br>
                Ҳисобрақам: <?= $model->producer->companyBankAccount->account ?>
                <br>
                Банк: <?= $model->producer->companyBankAccount->bank->name ?>
                <br>
                МФО: <?= $model->producer->companyBankAccount->mfo ?>
                <br>
                Шартнома ЭРИ  орқали тузилган. <br><br><br><br><br><br><br>
            </td>
            <td></td>
            <td>
                <b>БУЮРТМАЧИ </b>
                <br>
                Номи: <?= $model->customer->name ?>
                <br>
                Манзили: <?= $model->customer->address ?>
                <br>
                Тел.: <?= $model->customer->phone ?>
                <br>
                e-mail: <?= $model->customer->email ?>
                <br>
                СТИР: <?= $model->customer->tin ?>
                <br>
                Ҳисобрақам: <?= $model->customer->companyBankAccount->account ?>
                <br>
                Банк: <?= $model->customer->companyBankAccount->bank->name ?>
                <br>
                МФО: <?= $model->customer->companyBankAccount->mfo ?>
                <br>
                Шартнома ЭРИ  орқали тузилган<br><br><br><br><br><br><br>
            </td>
        </tr>
    </tbody>
</table>

<table class="mt-15 text-left">
    <tbody>
        <tr>
            <td class="text-left p-10">
                <b>Шартнома тўлови бўйича Операторнинг реквизитлари</b>
                <br>
                СТИР: 307442330
                <br>
                Банк МФО 00419, "Ипотека-Банк"
                <br>
                Ҳисобрақам: 20210000805235588100
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