<?php

namespace frontend\controllers;

use common\models\Company;
use common\models\Product;
use common\models\User;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class ProducersController extends FrontendController
{

    public function actionIndex($name = null, $region_id = null, $type = null)
    {
        $users = User::find()->joinWith("role")->joinWith("company")->joinWith('company.products')->where(['user.status' => 10, 'product.status' => Product::STATUS_ACTIVE, 'item_name' => "member", 'is_crafter' => 1])->orderBy("count(product.id) desc")->groupBy("user.id");

        if ($name) {
            $users->andWhere(['LIKE', 'company.name', $name]);
        }

        if ($region_id){
            $users->andWhere(['company.region_id' => $region_id]);
        }

        if ($type){
            $users->andWhere(['company.type' => $type]);
        }

        return $this->render("index", [
            'users' => $users->all(),
            'name' => $name,
            'region_id' => $region_id,
            'type' => $type
        ]);
    }
    
    public function actionView($url = null, $company_id)
    {
        $products = Product::find()->joinWith("productTranslates")
            ->where(['status' => Product::STATUS_ACTIVE])->andWhere(['company_id' => $company_id])->orderBy('id desc');

        $pages = new Pagination([
            'totalCount' => $products->count(),
            'defaultPageSize' => 36
        ]);

        $products->offset($pages->offset)->limit($pages->limit);

        $company = Company::findOne($company_id);

        if (!$company) throw new NotFoundHttpException(t("Страница не найдена"));

        if ($company->user->status != User::STATUS_ACTIVE) throw new NotFoundHttpException(t("Страница не найдена"));

        return $this->render('view', [
            'products' => $products->all(),
            'pages' => $pages,
            'company' => $company
        ]);
    }
}
