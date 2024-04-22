<?php

namespace frontend\modules\user;

use common\models\User;
use Yii;

/**
 * user module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\user\controllers';
    public $defaultRoute = "profile";

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        Yii::$app->session->set("platform_type", "customer");
    }

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash("danger", t("Пожалуйста, авторизуйтесь."));
            Yii::$app->response->redirect(toRoute(['/site/login']))->send();
            return false;
        } else if (Yii::$app->user->identity->type == User::TYPE_PRODUCER) {
            Yii::$app->session->setFlash("danger", t("Вы не являетесь покупателем."));
            Yii::$app->response->redirect(toRoute(['/cabinet']))->send();
            return false;
        }

        return parent::beforeAction($action);
    }
}
