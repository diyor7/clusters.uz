<?php

namespace frontend\modules\cabinet\controllers;

use common\models\User;
use frontend\controllers\FrontendController;
use Yii;

/**
 * Default controller for the `cabinet` module
 */
class BalanceController extends FrontendController
{
    public function actionIndex()
    {
        $user = User::findOne(Yii::$app->user->id);

        $company = $user->company;

        $company_balance = $company ? $company->companyBalance : null;

        if ($company_balance) {
            $company_balance->calculateBalance();
        } else {
            Yii::$app->session->setFlash('warning', t("Для работы с балансом необходимо указать свой банковский счет."));

            return $this->redirect(toRoute('/cabinet/requisite'));
        }

        return $this->render('index', [
            'user' => $user,
            'company' => $company,
            'company_balance' => $company_balance
        ]);
    }
    public function actionVisibility()
    {
        $user = User::findOne(Yii::$app->user->id);

        $company = $user->company;

        $company_balance = $company ? $company->companyBalance : null;

        if ($company_balance) {
            if ($company_balance->show_balance === 1) {
                $company_balance->show_balance = 0;
            } else {
                $company_balance->show_balance = 1;
            }

            $company_balance->save();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }
}
