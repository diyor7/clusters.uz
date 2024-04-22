<?php

namespace frontend\modules\user\controllers;

use common\models\Address;
use common\models\User;
use frontend\controllers\FrontendController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Default controller for the `user` module
 */
class AddressController extends FrontendController
{
    public function actionIndex()
    {
        $addresses = Address::findAll(['user_id' => Yii::$app->user->id]);

        return $this->render('index', [
            'addresses' => $addresses
        ]);
    }

    public function actionHandle($id = null)
    {
        $model = Address::findOne($id);

        if (!$model)
            $model = new Address([
                'user_id' => Yii::$app->user->id,
                'created_at' => date("Y-m-d H:i:s"),
                'latitude' => 41.311081,
                'longitude' => 69.240562
            ]);

        if ($model->load($_POST) && $model->save()) {
            Yii::$app->session->setFlash("success", t("Адрес успешно сохранен."));

            return $this->redirect(['index']);
        }

        return $this->render('handle', [
            'model' => $model
        ]);
    }

    public function actionCreateAjax()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new Address([
            'user_id' => Yii::$app->user->id,
            'created_at' => date("Y-m-d H:i:s"),
            'latitude' => 41.311081,
            'longitude' => 69.240562
        ]);

        if ($model->load($_POST) && $model->save()) {
            return [
                'status' => 'success',
                'id' => $model->id,
                'text' => $model->text,
                'name' => $model->name
            ];
        }

        return [
            'status' => 'error',
            'errors' => $model->errors
        ];
    }

    public function actionDelete($id)
    {
        $model = Address::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException(t("Страница не найдена"));
        }

        $model->delete();

        Yii::$app->session->setFlash('success', t("Адрес успешно удален."));

        return $this->redirect(Yii::$app->request->referrer);
    }
}
