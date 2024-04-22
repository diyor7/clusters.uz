<?php

/**
 * -----------------------------------------------------------------------------
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * -----------------------------------------------------------------------------
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use Yii;

/**
 * -----------------------------------------------------------------------------
 * @author Qiang Xue <qiang.xue@gmail.com>
 *
 * @since 2.0
 * -----------------------------------------------------------------------------
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        // "css/style.css?9",
        "https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css",
        "https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css",
        "https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css",
        "https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css",
        "https://unpkg.com/swiper@7/swiper-bundle.min.css",
        // 'css/magnific-popup.css'
        // "vendor/owl.carousel/assets/owl.carousel.min.css",
        // "vendor/owl.carousel/assets/owl.theme.default.min.css",
        "vendor/magnific.popup/magnific-popup.css",
        "fonts/opensans.css",
        "fonts/roboto/roboto.css",
        "vendor/icomoon/icomoon.css",
        "css/bootstrap.css",
        "css/style.css?22",
        "css/media.css?7",
        "css/restyle.css"
    ];

    public $js = [
        // "https://unpkg.com/@popperjs/core@2",
        // "https://unpkg.com/tippy.js@6",
        // "https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js",
        // "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js",
        // "https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js",
        // "https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js",
        "https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js",
        "https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js",
        "https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/ru.js",
        "https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/uz.js",
        "//cdn.jsdelivr.net/npm/sweetalert2@10",
        "https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js",
        // // "js/jquery.magnific-popup.min.js",
        // "js/scripts.js?6",
        "vendor/bootstrap/bootstrap.bundle.min.js",
        "vendor/touch.spin/jquery.bootstrap-touchspin.min.js",
        // "vendor/owl.carousel/owl.carousel.min.js",
        "vendor/magnific.popup/jquery.magnific-popup.min.js",
        "vendor/wow.js/wow.min.js",
        "https://unpkg.com/swiper@7/swiper-bundle.min.js",
        "js/main.js?8",
        '/js/pdfobject.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
