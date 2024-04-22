<?php

namespace frontend\modules\crm\controllers;

use common\models\User;
use frontend\controllers\FrontendController;
use frontend\models\UserEditForm;
use Yii;

/**
 * Default controller for the `cabinet` module
 */
class ProfileController extends FrontendController
{
    public function actionIndex()
    {
        $user = User::findOne(Yii::$app->user->id);

        $model = new UserEditForm([
            'full_name' => $user->full_name,
            'username' => $user->username,
            'email' => $user->email,
            'address' => $user->address
        ]);

        if ($model->load($_POST) && $model->validate()) {
            
            $model->username = $user->username;

            if ($model->save()) {
                Yii::$app->session->setFlash("success", t("Личные данные успешно сохранены"));

                return $this->redirect(['index']);
            }
        }

        return $this->render('index', [
            'user' => $user,
            'model' => $model
        ]);
    }

    public function actionUpdate()
    {
        $user = User::findOne(Yii::$app->user->id);

        $model = new UserEditForm([
            'full_name' => $user->full_name,
            'username' => $user->username,
            'email' => $user->email,
            'address' => $user->address
        ]);

        if ($model->load($_POST) && $model->validate()) {
            
            $model->username = $user->username;

            if ($model->save()) {
                Yii::$app->session->setFlash("success", t("Личные данные успешно сохранены"));

                return $this->redirect(['index']);
            }
        }

        return $this->render('index', [
            'user' => $user,
            'model' => $model
        ]);
    }
}
