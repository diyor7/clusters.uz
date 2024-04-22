<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 18.05.2017
 * Time: 0:55
 */

return [
    '/' => 'site/index',
    '/search' => 'search/index',
    '/offerta' => 'site/offerta',
    '/instruction' => 'site/instruction',
    '/purchases' => 'site/purchases',
    '/page/new/<url:[\w\-]+>--<id:\d+>' => '/page/new/',
    '/cabinet/product/add' => 'cabinet/product/handle',
    '/cabinet/product/update/<id>' => 'cabinet/product/handle',
    '/cabinet/product/set-active/<id>' => 'cabinet/product/set-active',
    '/cabinet/product/set-archive/<id>' => 'cabinet/product/set-archive',
    '/cabinet/product/delete/<id>' => 'cabinet/product/delete',

    '/user/product/add' => 'user/product/handle',
    '/user/product/update/<id>' => 'user/product/handle',
    '/user/product/delete/<id>' => 'user/product/delete',
    
    '/cabinet/order/<id>' => 'cabinet/order/view',
    '/cabinet/order/delete/<id>' => 'cabinet/order/delete',
    '/cabinet/order/update/<id>' => 'cabinet/order/update',
    
    '/cabinet/request/<id:\d+>' => 'cabinet/request/view',
    '/cabinet/contract/pdf/<id:\d+>' => 'cabinet/contract/pdf',
    '/cabinet/contract/<id:\d+>' => 'cabinet/contract/view',

    '/user/order/<id:\d+>' => 'user/order/view',
    '/user/contract/pdf/<id:\d+>' => 'user/contract/pdf',
    '/user/contract/<id:\d+>' => 'user/contract/view',

    '/user/request/<id:\d+>' => 'user/request/view',
    
    '/user/auction/update/<id:\d+>' => 'user/auction/update',

    '/user/address/create' => 'user/address/handle',
    '/user/address/update/<id>' => 'user/address/handle',
    '/user/address/delete/<id>' => 'user/address/delete',

    '/pages/<url>' => 'page/view',

    '/store/<url:[0-9a-zA-Z\-]+>--<id:\d+>' => 'store/product/index',
    '/store/<layout:list>/<url:[0-9a-zA-Z\-]+>--<id:\d+>' => 'store/product/index',
    '/store/product/<url:[0-9a-zA-Z\-]+>--<id:\d+>' => 'store/product/view',
    '/store/producers/<url:[0-9a-zA-Z\-]+>--<company_id:\d+>' => 'store/producers/view',

    '/auction/view/<id:\d+>' => 'auction/default/view',
    '/auction/offer/<id:\d+>/<price:\d+>' => 'auction/default/offer',
    '/auction/offer/<id:\d+>' => 'auction/default/view',
    '/tender/view/<id:\d+>' => 'tender/default/view',
    '/competition/view/<id:\d+>' => 'competition/default/view',

    '/<platform_type:customer>' => '/site/change-platform',
    '/<platform_type:producer>' => '/site/change-platform',
    '/trade/index' => '/trade/index',
    '/trade/view/<id:\d+>' => 'trade/view',

    '/cluster/<cluster>' => "/cluster/index",
    '/cluster/<cluster>/product' => "/cluster/product",
    '/cluster/<cluster>/import' => "/cluster/import",
    '/cluster/<cluster>/import/<id>' => "/cluster/import-view",
];