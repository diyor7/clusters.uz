<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

/**
 * FrontendController extends Controller and implements the behaviors() method
 * where you can specify the access control ( AC filter + RBAC) for
 * your controllers and their actions.
 */
class FrontendController extends Controller
{
    /**
     * Returns a list of behaviors that this component should behave as.
     * Here we use RBAC in combination with AccessControl filter.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'controllers' => [
                            'cabinet/product', 'cabinet/order', 'cabinet/request', 'cabinet/profile',
                            'cabinet/address', 'cabinet/favorite', 'cabinet/notification', 'cabinet/requisite', 'cabinet/balance',
                            'cabinet/contract',
                        ],
                        'allow' => true,
                        'roles' => ['member', 'seller']
                    ],
                    [
                        'controllers' => [
                            'user/product', 'user/profile', 'user/address', 'user/favorite', 'user/favorite/users',
                            'user/order', 'user/request', 'user/notification', 'user/requisite',
                            'user/contract', 'user/balance', 'user/auction'
                        ],
                        'allow' => true,
                        'roles' => ['member', 'seller']
                    ],
                    [
                        'controllers' => ['auction/default'],
                        'actions' => ['add', 'offer', 'my-lots', 'my-trades', 'search', 'category-form', 'get-prices'],
                        'allow' => true,
                        'roles' => ['member', 'seller']
                    ],
                    [
                        'controllers' => ['auction/default'],
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?', '@']
                    ],
                    [
                        'controllers' => ['tender/default'],
                        'actions' => ['add', 'offer', 'my-lots', 'my-trades', 'search', 'tn-form'],
                        'allow' => true,
                        'roles' => ['member', 'seller']
                    ],
                    [
                        'controllers' => ['tender/default'],
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?', '@']
                    ],
                    [
                        'controllers' => ['competition/default'],
                        'actions' => ['add', 'offer', 'my-lots', 'my-trades', 'search', 'tn-form'],
                        'allow' => true,
                        'roles' => ['member', 'seller']
                    ],
                    [
                        'controllers' => ['competition/default'],
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?', '@']
                    ],
                    [
                        'controllers' => ['ajax'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'controllers' => ['store/product', 'page', 'store/cart', 'store/order', 'store/search', 'producers', 'store/category', 'trade/index'],
                        'allow' => true,
                        'roles' => ['?', '@']
                    ],
                ], // rules

            ], // access

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ], // verbs

        ]; // return

    } // behaviors

} // AppController
