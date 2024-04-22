<?php

namespace frontend\controllers;

use common\models\Favorite;
use common\models\Property;
use Yii;
use yii\web\Response;

class AjaxController extends FrontendController
{
    public function actionLoadProperties($category_id, $product_id = null)
    {
        if (Yii::$app->request->isAjax) {
            $properties = Property::findAll(['category_id' => $category_id]);

            return $this->renderAjax('load-properties', [
                'properties' => $properties,
                'product_id' => $product_id
            ]);
        }
    }

    public function actionFavorite ($product_id){   
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->user->isGuest) {
            return [
                'status' => 'auth'
            ];
        }

        $favorite = Favorite::findOne([
            'product_id' => $product_id,
            'user_id' => Yii::$app->user->id
        ]);

        if ($favorite) {
            $favorite->delete();

            return [
                'status' => 'off',
                'message' => t("Товар удален из избранных"),
                'text' => t('Добавить в избранное')
            ];
        }

        if (!$favorite) {
            $favorite = new Favorite([
                'product_id' => $product_id,
                'user_id' => Yii::$app->user->id
            ]);

            if ($favorite->save()) {
                return [
                    'status' => 'on',
                    'message' => t("Товар добавлен в избранные"),
                    'text' => t('Удалить из избранных')
                ];
            }
        }

        return [
            'status' => 'error',
            'message' => "Cant not save"
        ];
    }

    public function actionUserFavorite ($company_id){   
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->user->isGuest) {
            return [
                'status' => 'auth'
            ];
        }

        $favorite = Favorite::findOne([
            'company_id' => $company_id,
            'user_id' => Yii::$app->user->id
        ]);

        if ($favorite) {
            $favorite->delete();

            return [
                'status' => 'off',
                'message' => t("Производитель удален из избранных"),
                'text' => t('Добавить в избранное')
            ];
        }

        if (!$favorite) {
            $favorite = new Favorite([
                'company_id' => $company_id,
                'user_id' => Yii::$app->user->id
            ]);

            if ($favorite->save()) {
                return [
                    'status' => 'on',
                    'message' => t("Производитель добавлен в избранные"),
                    'text' => t('Удалить из избранных')
                ];
            }
        }

        return [
            'status' => 'error',
            'message' => "Cant not save"
        ];
    }
}
