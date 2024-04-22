<?php
function getTranslate($translate, $params = [])
{
    return Yii::t('main', $translate) !== "" ? Yii::t('main', $translate, $params) : $translate;
}
function t($translate, $params = [])
{
    return getTranslate($translate, $params);
}

function siteUrl($actual = 0)
{
    if ($_SERVER['SERVER_NAME'] == "control.clusters.uz") {
        return "https://clusters.uz/";
    }

    $url = \yii\helpers\Url::to('/', true);
    if (!$actual) {
        switch (true) {
            case strpos($url, 'admin.'):
                return str_replace('admin.', '', $url);
                break;
            case strpos($url, 'admin.'):
                return str_replace('admin.', '', $url);
                break;
        }
    }
    return $url;
}

function convertImageToWebP($source, $destination, $quality = 100)
{
    $extension = pathinfo($source, PATHINFO_EXTENSION);
    if ($extension == 'jpeg' || $extension == 'jpg')
        $image = imagecreatefromjpeg($source);
    elseif ($extension == 'gif')
        $image = imagecreatefromgif($source);
    elseif ($extension == 'png')
        $image = imagecreatefrompng($source);
    return imagewebp($image, $destination, $quality);
}

function toRoute($route, $scheme = false)
{
    return \yii\helpers\Url::toRoute($route);
}

function isHome()
{
    $controller = \Yii::$app->controller;
    $default_controller = \Yii::$app->defaultRoute;
    return (($controller->id === $default_controller) && ($controller->action->id === $controller->defaultAction)) ? true : false;
}

function isHomeUrl()
{
    $controller = \Yii::$app->controller;
    $default_controller = \Yii::$app->defaultRoute;
    return (($controller->id === 'site') && ($controller->action->id === 'home')) ? true : false;
}

/*
    * logged user datas
*/
function user_datas()
{
    return \Yii::$app->user->identity;
}
/*
    *
    *		FUNCTION FOR FAST PRINTING ARRAYS
    *
*/
function pre($arr = array())
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

/*
    * get app current lang name without il18n code (example: ru-Ru = ru)
*/
function appLang()
{
    $lang = \Yii::$app->language;
    // return substr($lang, 0,strpos($lang, '-'));
    return $lang;
}


/*
    * url generator
*/

function toAscii($str, $delimiter = '-')
{
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', rus2translit(trim($str)));
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[_|+ -]+/", $delimiter, $clean);
    return $clean;
}

/*
    * transitration
*/
function rus2translit($string)
{
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'yo',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '',  'ы' => 'y',   'ъ' => '',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
        'ў' => 'u',   'қ' => 'q',

        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'Yo',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        'Ў' => 'U',   'Қ' => 'Q',

        '/' => '-',   ' ' => '-',   '\'' => '',
        '"' => '',    ',' => '',    '.' => '',
        '‘' => '',    '(' => '',    ')' => '',
        ']' => '',    '[' => '',    '}' => '',
        '{' => '',    '?' => '',
    );
    return strtr($string, $converter);
}

/*
    * оброботчик картинок
*/
// crop
function crop($filename, $width, $height, $path, $suffix = 'croped_', array $start = [0, 0], $quality = 80)
{
    if ($filename && file_exists(Yii::getAlias('@uploads/' . $path . '/' . $suffix . $filename))) { // смотрим, нет ли такой картинки на сервере, то есть, не была ли она уже обрезана
        \yii\imagine\Image::crop(Yii::getAlias('@uploads/' . $path . '/' . $filename), $width, $height, $start)->save(Yii::getAlias('@uploads/' . $path . '/' . $suffix . $filename), ['quality' => $quality]);
        return siteUrl() . 'uploads/' . $path . '/' . $suffix . $filename;
    } else {
        return  'File not found!';
    }
    return false;
}

// thumbnail
function thumbnail($filename, $width, $height, $path, $suffix = 'thumb_')
{
    if ($filename && file_exists(Yii::getAlias('@uploads/' . $path . '/' . $filename))) {
        if (!file_exists(Yii::getAlias('@uploads/' . $path . '/' . $suffix . $filename))) { // смотрим, нет ли такой картинки на сервере, то есть, не была ли она уже обрезана
            \yii\imagine\Image::thumbnail(Yii::getAlias('@uploads/' . $path . '/' . $filename), $width, $height)->save(Yii::getAlias('@uploads/' . $path . '/' . $suffix . $filename));
        }
        return siteUrl() . 'uploads/' . $path . '/' . $suffix . $filename;
    } else {
        return 'File not found!';
    }
}

// resize
function resize($filename, $size, $path, $type = 'widen', $suffix = 'resized_')
{
    $imagine = new \Imagine\Gd\Imagine();
    if ($filename && file_exists(Yii::getAlias('@uploads/' . $path . '/' . $filename))) { // смотрим, нет ли
        if (!file_exists(Yii::getAlias('@uploads/' . $path . '/' . $suffix . $filename))) {
            $image = $imagine->open(Yii::getAlias('@uploads/' . $path . '/' . $filename));
            // get original size and set width (widen) or height (heighten).
            // width or height will be set maintaining aspect ratio.
            switch ($type) {
                case 'widen':
                    $image->resize($image->getSize()->widen($size));
                    break;
                case 'heighten':
                    $image->resize($image->getSize()->heighten($size));
                    break;
            }
            $image->save(Yii::getAlias('@uploads/' . $path . '/' . $suffix . $filename));
        }
        return siteUrl() . 'uploads/' . $path . '/' . $suffix . $filename;
    } else {
        return 'File not found!';
    }
}

function letters($lang)
{
    $arr = [
        'ru' => [
            'А',
            'Б',
            'В',
            'Г',
            'Д',
            'Е',
            'Ё',
            'Ж',
            'З',
            'И',
            'Й',
            'К',
            'Л',
            'М',
            'Н',
            'О',
            'П',
            'Р',
            'С',
            'Т',
            'У',
            'Ф',
            'Х',
            'Ц',
            'Ч',
            'Ш',
            'Щ',
            'Ъ',
            'Ы',
            'Ь',
            'Э',
            'Ю',
            'Я',
        ],
        'en' => [
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
            'Q',
            'R',
            'S',
            'T',
            'U',
            'V',
            'W',
            'X',
            'Y',
            'Z',
        ]
    ];

    if (array_key_exists($lang, $arr)) {
        return $arr[$lang];
    } else {
        return [];
    }
}

function month2Rus($month)
{
    $arr = array(
        1 => getTranslate("january"),
        2 => getTranslate("fabruary"),
        3 => getTranslate("march"),
        4 => getTranslate("april"),
        5 => getTranslate("may"),
        6 => getTranslate("june"),
        7 => getTranslate("july"),
        8 => getTranslate("august"),
        9 => getTranslate("september"),
        10 => getTranslate("october"),
        11 => getTranslate("november"),
        12 => getTranslate("december")
    );
    $month = ltrim($month, '0');
    return $arr[$month];
}

function getResponseFromHunarUz($tin)
{
    try {
        $url = 'https://hunar.uz/api/get_hunarmand?tin=' . $tin . '&lang=' . Yii::$app->language;

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        $response = json_decode($result, true);

        return $response;
    } catch (\Exception $ex) {
        return null;
    }
}

function checkPkcs($pkcs7)
{

    $xmlcontent = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/"><Body><verifyPkcs7 xmlns="http://v1.pkcs7.plugin.server.dsv.eimzo.yt.uz/"><pkcs7B64 xmlns="">' . $pkcs7 . '</pkcs7B64></verifyPkcs7></Body></Envelope>';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml; charset="UTF-8"'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:9090/dsvs/pkcs7/v1");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlcontent);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);

        return [
            'status' => 'error',
            'message' => $error_msg
        ];
    }

    $response = str_replace([
        '<?xml version="1.0" ?><S:Envelope xmlns:S="http://schemas.xmlsoap.org/soap/envelope/"><S:Body><ns2:verifyPkcs7Response xmlns:ns2="http://v1.pkcs7.plugin.server.dsv.eimzo.yt.uz/"><return>',
        '</return></ns2:verifyPkcs7Response></S:Body></S:Envelope>'
    ], '', $response);

    return $response;
}


function showPrice($price)
{
    return number_format($price, 2, '.', ' ');
}

function showQuantity($quantity)
{
    return number_format($quantity, 0, '.', ' ');
}

function showNorm($string)
{
    $parts = explode(", ", $string);

    $str = "";

    foreach ($parts as $index => $part) {
        if ((int) ((count($parts)  - 1) / 2) == $index) {
            $str .= $part . ", <br>";
        } else {
            $str .= $part . ", ";
        }
    }

    return $str;
}

function modify_url_query($url, $mod)
{
    $purl = parse_url($url);
    $params = array();
    if (isset($purl['query']) && ($query_str = $purl['query'])) {
        parse_str($query_str, $params);
        foreach ($params as $name => $value) {
            if (isset($mod[$name])) {
                $params[$name] = $mod[$name];
                unset($mod[$name]);
            }
        }
    }
    $params = array_merge($params, $mod);
    $ret = "";
    if (isset($purl['scheme']) && $purl['scheme']) {
        $ret = $purl['scheme'] . "://";
    }
    if (isset($purl['host']) && $purl['host']) {
        $ret .= $purl['host'];
    }
    if (isset($purl['path']) && $purl['path']) {
        $ret .= $purl['path'];
    }
    if ($params) {
        $ret .= '?' . http_build_query($params);
    }
    if (isset($purl['fragment']) && $purl['fragment']) {
        $ret .= "#" . $purl['fragment'];
    }
    return $ret;
}

function shorter($text, $chars_limit)
{
    $text = strip_tags($text);
    // Check if length is larger than the character limit
    if (strlen($text) > $chars_limit) {
        // If so, cut the string at the character limit
        $new_text = substr($text, 0, $chars_limit);
        // Trim off white space
        $new_text = trim($new_text);
        // Add at end of text ...
        return $new_text . "...";
    }
    // If not just return the text as is
    else {
        return $text;
    }
}

function calculateInterval($date)
{
    $now = time(); // or your date as well
    $date = strtotime($date);
    $datediff = $now - $date;

    $days = round($datediff / (60 * 60 * 24));

    if ($days > 365) {
        $years = floor($days / 365);
        return plural($years, t("год"), t("года"), t("лет"));
    } else if ($days > 30) {
        $months = floor($days / 30);
        return plural($months, t("месяц"), t("месяца"), t("месяцев"));
    }

    return plural($days, t("день"), t("дня"), t("дней"));
}

/**
 * Склонение существительных с числительными.
 * Функция принимает число $n и три строки - 
 * разные формы произношения измерения величины.
 * Необходимая величина будет возвращена.
 * Например: pluralForm(100, "рубль", "рубля", "рублей")
 * вернёт "рублей".
 * 
 * @param int величина
 * @param string форма1
 * @param string форма2
 * @param string форма3
 * @return string
 */
function plural($n, $form1, $form2, $form3)
{
    $n = abs($n) % 100;
    $n1 = $n % 10;

    if ($n > 10 && $n < 20) {
        return $n . ' ' . $form3;
    }

    if ($n1 > 1 && $n1 < 5) {
        return $n . ' ' . $form2;
    }

    if ($n1 == 1) {
        return $n . ' ' . $form1;
    }

    return $n . ' ' . $form3;
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if (!$length) {
        return true;
    }
    return substr($haystack, -$length) === $needle;
}

function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return substr($haystack, 0, $length) === $needle;
}
