<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'cabinet' => [
            'class' => 'frontend\modules\cabinet\Module',
        ],
        'user' => [
            'class' => 'frontend\modules\user\Module',
        ],
        'store' => [
            'class' => 'frontend\modules\store\Module',
        ],
        'auction' => [
            'class' => 'frontend\modules\auction\Module',
        ],
        'tender' => [
            'class' => 'frontend\modules\tender\Module',
        ],
        'competition' => [
            'class' => 'frontend\modules\competition\Module',
        ],
        'organisation' => [
            'class' => 'frontend\modules\organisation\Module',
        ],
        'crm' => [
            'class' => 'frontend\modules\crm\Module',
        ],
        'cron' => [
            'class' => 'frontend\modules\cron\Module',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'languageId' => [
            'class' => 'common\components\LanguageId'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'class' => 'common\components\LangUrlManager',
            'rules' => require('urlRules.php')
        ],
        'request' => [
            'class' => 'common\components\LangRequest',
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '/',
        ],
    ],
    'params' => $params,
];
