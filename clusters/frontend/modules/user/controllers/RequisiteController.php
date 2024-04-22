<?php

namespace frontend\modules\user\controllers;

use common\models\Company;
use common\models\CompanyBankAccount;
use common\models\User;
use frontend\controllers\FrontendController;
use yii\base\Model;
use Yii;

class RequisiteController extends FrontendController
{
    public function actionIndex()
    {
        $user = User::findOne(Yii::$app->user->id);
        $user_profile = $user->user_profile;

        if ($user->companyType == Company::TYPE_PHYSICAL) {
            Yii::$app->session->setFlash("danger", t("Вы не являетесь юридическим лицом"));
            
            return $this->redirect('/user');
        }

        $model = $user->company;
        $account = CompanyBankAccount::findOne(['company_id' => $user->company_id, 'is_main' => 1]);

        if (!$model) {
            $model = new Company;
        }

        if (!$account) {
            $account = new CompanyBankAccount([
                'is_main' => 1,
                'created_at' => date("Y-m-d H:i:s"),
            ]);
        } else {
            $account->updated_at = date("Y-m-d H:i:s");
        }

        unset($_POST['Company[tin]']);
        unset($_POST['Company[type]']);
        unset($_POST['Company[id]']);

        if ($model->load($_POST) && $account->load($_POST) && Model::validateMultiple([$model, $account])) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', t("Реквизиты успешно сохранены."));
                $account->company_id = $model->id;
                $account->save();

                if (!$user->company_id) {
                    $user->company_id = $model->id;
                    $user->save(false);
                }
            }

            return $this->redirect(['index']);
        }

        return $this->render('index', [
            'user' => $user,
            'model' => $model,
            'account' => $account
        ]);
    }
}
