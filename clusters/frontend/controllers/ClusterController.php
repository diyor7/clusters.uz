<?php

namespace frontend\controllers;

use common\models\Company;
use common\models\ProcurementPlan;
use common\models\Product;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ClusterController extends Controller
{
    private function cluster($cluster)
    {
        switch ($cluster) {
            case "agmk":
                return [
                    'title' => t("Алмалыкский горно-металлургический комбинат"),
                    "tin" => "202328794",
                    "cluster" => $cluster
                ];
            case "ngmk":
                return [
                    'title' => t("Навоийский горно-металлургический комбинат"),
                    "tin" => "308425864",
                    "cluster" => $cluster
                ];
            default:
                throw new NotFoundHttpException("Page not found");
        }
    }

    public function actionIndex($cluster)
    {
        $data = $this->cluster($cluster);

        return $this->render("index", [
            'data' => $data
        ]);
    }
    
    public function actionProduct($cluster)
    {
        $data = $this->cluster($cluster);

        $company = Company::findOne(['tin' => $data['tin']]);

        if (!$company) throw new NotFoundHttpException("Company not found");

        $products = Product::find()->where(['company_id' => $company->id, 'status' => Product::STATUS_ACTIVE])->orderBy("id desc");

        $count = $products->groupBy('product.id')->count();

        $pages = new Pagination([
            'totalCount' => $products->count(),
            'defaultPageSize' => 36,
            'pageSizeLimit' => [1, 36 * 3]
        ]);

        $products->offset($pages->offset)->limit($pages->limit)->groupBy('product.id');

        return $this->render("product", [
            'products' => $products->all(),
            'count' => $count,
            'pages' => $pages,
            'data' => $data
        ]);
    }

    public function actionImport($cluster)
    {
        $data = $this->cluster($cluster);

        $company = Company::findOne(['tin' => $data['tin']]);

        if (!$company) throw new NotFoundHttpException("Company not found");

        $plans = ProcurementPlan::find()->where(['company_id' => $company->id])->orderBy("year desc, kvartal desc");

        $count = $plans->groupBy('id')->count();

        $pages = new Pagination([
            'totalCount' => $plans->count(),
            'defaultPageSize' => 36,
            'pageSizeLimit' => [1, 36 * 3]
        ]);

        $plans->offset($pages->offset)->limit($pages->limit)->groupBy('id');

        return $this->render("import", [
            'plans' => $plans->all(),
            'count' => $count,
            'pages' => $pages,
            'data' => $data
        ]);
    }

    public function actionImportView($cluster, $id)
    {
        $data = $this->cluster($cluster);

        $company = Company::findOne(['tin' => $data['tin']]);

        if (!$company) throw new NotFoundHttpException("Company not found");

        $plan = ProcurementPlan::findOne(['company_id' => $company->id, 'id' => $id]);

        if (!$plan) throw new NotFoundHttpException("Plan not found");

        return $this->render("import-view", [
            'plan' => $plan,
            'data' => $data
        ]);
    }
}
