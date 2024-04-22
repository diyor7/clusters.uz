<?php

namespace frontend\modules\cabinet;

use common\models\User;
use Yii;

/**
 * cabinet module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\cabinet\controllers';
    public $defaultRoute = "profile";

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        Yii::$app->session->set("platform_type", "producer");
    }

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash("danger", t("Пожалуйста, авторизуйтесь."));
            Yii::$app->response->redirect(toRoute(['/site/login']))->send();
            return false;
        } else if (Yii::$app->user->identity->type == User::TYPE_CUSTOMER) {
            Yii::$app->session->setFlash("danger", t("Вы не являетесь поставщиком."));
            Yii::$app->response->redirect(toRoute(['/user']))->send();
            return false;
        }

        if (!Yii::$app->user->identity->company_id && Yii::$app->controller->id != 'requisite') {
            Yii::$app->session->setFlash("warning", t("Заполните свои реквизиты, чтобы работать в качестве поставщика."));
            Yii::$app->response->redirect(toRoute(['/cabinet/requisite']))->send();
            return false;
        }

        return parent::beforeAction($action);
    }
}
