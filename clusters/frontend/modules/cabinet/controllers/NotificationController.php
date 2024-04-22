<?php

namespace frontend\modules\cabinet\controllers;

use common\models\Notification;
use common\models\User;
use frontend\controllers\FrontendController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Default controller for the `cabinet` module
 */
class NotificationController extends FrontendController
{
    public function actionIndex()
    {
        $notifications = Notification::find()->where(['user_id' => Yii::$app->user->id, 'is_read' => 0])->orderBy("is_read asc, id desc");

        return $this->render('index', [
            'notifications' => $notifications->all()
        ]);
    }

    public function actionDelete($id) {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $notification = Notification::findOne(['id' => $id, 'user_id' => Yii::$app->user->id]);

        if (!$notification) throw new NotFoundHttpException(t("Страница не найдена"));

        $notification->is_read = 1;
        $notification->save(false);

        return [
            'status' => "success",
            'message' => t("Уведомление успешно удалено.")
        ];
    }
}
