<?php

namespace frontend\modules\competition\controllers;

use common\models\Auction;
use common\models\AuctionCondition;
use common\models\AuctionRequest;
use common\models\AuctionTn;
use common\models\CompanyTransaction;
use common\models\Tn;
use common\models\User;
use frontend\controllers\FrontendController;
use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class DefaultController extends FrontendController
{
    public function actionIndex($name = null, $region_id = null, $summa_from = null, $summa_to = null, $tn_id = null, $auction_end = null)
    {
        $models = Auction::find()->where(['auction.status' => Auction::STATUS_ACTIVE])->joinWith("auctionTns.tn.tnTranslates")->orderBy("auction.id desc");
        $models->groupBy("auction.id");

        $pages = new Pagination([
            'totalCount' => $models->count(),
            'defaultPageSize' => 9
        ]);

        $models->limit($pages->limit)->offset($pages->offset);

        $is_open = false;

        if ($name) {
            $models->andWhere([
                'or',
                ['auction.id' => $name],
                ['like', 'tn_translate.title', $name]
            ]);
            $is_open = true;
        }

        if ($region_id) {
            $models->andWhere(['auction.region_id' => $region_id]);
            $is_open = true;
        }

        if ($summa_from) {
            $models->andWhere(['>=', 'auction.total_sum', $summa_from]);
            $is_open = true;
        }

        if ($summa_to) {
            $models->andWhere(['<=', 'auction.total_sum', $summa_to]);
            $is_open = true;
        }

        if ($tn_id) {
            $models->andWhere(['auction_tn.tn_id' => $tn_id]);
            $is_open = true;
        }

        if ($auction_end) {
            $models->andWhere(['DATE(auction.auction_id)' => $auction_end]);
            $is_open = true;
        }

        return $this->render('index', [
            'models' => $models->all(),
            'title' => t("Электронный конкурс"),
            'pages' => $pages,
            'is_open' => $is_open,
            'name' => $name,
            'region_id' => $region_id,
            'summa_from' => $summa_from,
            'summa_to' => $summa_to,
            'tn_id' => $tn_id,
            'auction_end' => $auction_end
        ]);
    }

    public function actionMyLots($name = null, $region_id = null, $summa_from = null, $summa_to = null, $tn_id = null, $auction_end = null)
    {
        $user = User::findOne(Yii::$app->user->id);
        $models = Auction::find()->orderBy("auction.id desc");

        $models->andWhere(['company_id' => $user->company_id]);
        $models->groupBy("auction.id");

        $pages = new Pagination([
            'totalCount' => $models->count(),
            'defaultPageSize' => 9
        ]);

        $models->limit($pages->limit)->offset($pages->offset);

        $is_open = false;

        if ($name) {
            $models->andWhere([
                'or',
                ['auction.id' => $name],
                ['like', 'tn_translate.title', $name]
            ]);
            $is_open = true;
        }

        if ($region_id) {
            $models->andWhere(['auction.region_id' => $region_id]);
            $is_open = true;
        }

        if ($summa_from) {
            $models->andWhere(['>=', 'auction.total_sum', $summa_from]);
            $is_open = true;
        }

        if ($summa_to) {
            $models->andWhere(['<=', 'auction.total_sum', $summa_to]);
            $is_open = true;
        }

        if ($tn_id) {
            $models->andWhere(['auction_tn.tn_id' => $tn_id]);
            $is_open = true;
        }

        if ($auction_end) {
            $models->andWhere(['DATE(auction.auction_id)' => $auction_end]);
            $is_open = true;
        }

        return $this->render('index', [
            'models' => $models->all(),
            'title' => t("Мои лоты"),
            'pages' => $pages,
            'is_open' => $is_open,
            'name' => $name,
            'region_id' => $region_id,
            'summa_from' => $summa_from,
            'summa_to' => $summa_to,
            'tn_id' => $tn_id,
            'auction_end' => $auction_end

        ]);
    }

    public function actionMyTrades($name = null, $region_id = null, $summa_from = null, $summa_to = null, $tn_id = null, $auction_end = null)
    {
        $user = User::findOne(Yii::$app->user->id);
        $models = Auction::find()->orderBy("auction.id desc");

        $models->joinWith("auctionRequests")->andWhere(['auction_request.company_id' => $user->company_id]);
        $models->groupBy("auction.id");

        $pages = new Pagination([
            'totalCount' => $models->count(),
            'defaultPageSize' => 9
        ]);

        $models->limit($pages->limit)->offset($pages->offset);

        $is_open = false;

        if ($name) {
            $models->andWhere([
                'or',
                ['auction.id' => $name],
                ['like', 'tn_translate.title', $name]
            ]);
            $is_open = true;
        }

        if ($region_id) {
            $models->andWhere(['auction.region_id' => $region_id]);
            $is_open = true;
        }

        if ($summa_from) {
            $models->andWhere(['>=', 'auction.total_sum', $summa_from]);
            $is_open = true;
        }

        if ($summa_to) {
            $models->andWhere(['<=', 'auction.total_sum', $summa_to]);
            $is_open = true;
        }

        if ($tn_id) {
            $models->andWhere(['auction_tn.tn_id' => $tn_id]);
            $is_open = true;
        }

        if ($auction_end) {
            $models->andWhere(['DATE(auction.auction_id)' => $auction_end]);
            $is_open = true;
        }

        return $this->render('index', [
            'models' => $models->all(),
            'title' => t("Мои лоты"),
            'pages' => $pages,
            'is_open' => $is_open,
            'name' => $name,
            'region_id' => $region_id,
            'summa_from' => $summa_from,
            'summa_to' => $summa_to,
            'tn_id' => $tn_id,
            'auction_end' => $auction_end
        ]);
    }

    public function actionView($id)
    {
        $model = Auction::findOne(['id' => $id, 'status' => [Auction::STATUS_ACTIVE, Auction::STATUS_FINISHED]]);
        $user = User::findOne(Yii::$app->user->id);

        if (!$model) throw new NotFoundHttpException("Auction not found");

        $model->views++;
        $model->save();

        $name = "";

        foreach ($model->auctionTns as $index => $at) {
            $name .= $at->tn->title . ($index != count($model->auctionTns) - 1 ? ', ' : '');
        }

        return $this->render("view", [
            'model' => $model,
            'user' => $user,
            'name' => $name
        ]);
    }

    public function actionOffer($id, $price)
    {
        $model = Auction::findOne(['id' => $id, 'status' => [Auction::STATUS_ACTIVE, Auction::STATUS_FINISHED]]);
        $user = User::findOne(Yii::$app->user->id);

        if (!$model) {
            throw new NotFoundHttpException("Auction not found");
        }

        $request = new AuctionRequest([
            'company_id' => Yii::$app->user->identity->company_id,
            'auction_id' => $model->id,
            'is_winner' => 0
        ]);

        $next_price = $model->nextPrice;

        if ($next_price == $price) {
            if (!CompanyTransaction::findOne(['company_id' => $user->company_id, 'auction_id' => $model->id, 'type' => CompanyTransaction::TYPE_DEPOSIT])) {
                $total_block_sum = $model->total_sum * 3.15 / 100;

                $company_transaction = new CompanyTransaction([
                    'company_id' => $user->company_id,
                    'currency' => $total_block_sum,
                    'type' => CompanyTransaction::TYPE_DEPOSIT,
                    'auction_id' => $model->id,
                    'description' => t(""),
                    'status' => CompanyTransaction::STATUS_SUCCESS
                ]);

                if ($company_transaction->save()) {
                    Yii::$app->session->setFlash("info", t("С вашего баланса снято {summa} сум в виде залога.", [
                        'summa' => showPrice($total_block_sum)
                    ]));
                } else {
                    Yii::$app->session->setFlash("error", t("Не удалось снять средств с вашега баланса."));
                    return $this->redirect(Yii::$app->request->referrer);
                }
            }

            $request->price = $next_price;

            if ($request->save()) {
                Yii::$app->session->setFlash("success", t("Ваш запрос успешно принять"));
            } else {
                Yii::$app->session->setFlash("error", t("Не удалось принять ваш запрос, повторите попытку."));
            }
        } else {
            Yii::$app->session->setFlash("error", t("При обработке вашего запроса другой участник уже снизил цену."));
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionAdd()
    {
        $user = User::findOne(Yii::$app->user->id);

        $model = new Auction([
            'payment_period' => 5,
            'company_id' => \Yii::$app->user->identity->company_id,
            'status' => Auction::STATUS_MODERATING
        ]);

        $tns = [];


        if ($model->load($_POST) && $model->validate()) {
            if (isset($_POST['AuctionTn']) && is_array($_POST['AuctionTn']) && count($_POST['AuctionTn']) > 0) {
                $tns_count = 0;
                $auction_total_sum = 0;

                foreach ($_POST['AuctionTn'] as $key => $tn) {
                    $auction_tn = new AuctionTn();

                    $auction_tn->load(['AuctionTn' => $tn]);
                  
                    $tn_total_sum = $auction_tn->price * $auction_tn->quantity;
                    
                    $auction_tn->total_sum = $tn_total_sum;

                    if ($auction_tn->validate()) {
                        $auction_total_sum += ($tn_total_sum > 0 ? $tn_total_sum : 0);
                        $tns_count++;
                    }

                    $tns[] = $auction_tn;
                }

                $model->company_id = \Yii::$app->user->identity->company_id;
                $model->status = Auction::STATUS_MODERATING;
                $model->total_sum = $auction_total_sum;
                $model->auction_end = date("Y-m-d", strtotime("+10 days"));

                $total_block_sum = $model->total_sum * 3.15 / 100;

                if ($user->availableBalance < $total_block_sum) { // Недостаточно средств 
                    Yii::$app->session->setFlash('danger', t("Недостаточно средств на вашем балансе в системе"));
                    return $this->redirect(['add']);
                }

                if (count($tns) === count($_POST['AuctionTn'])) {
                    if ($model->save()) {
                        foreach ($model->condition_ids as $condition_id) {
                            $auction_condition = new AuctionCondition([
                                'auction_id' => $model->id,
                                'condition_id' => $condition_id,
                                'own' => 0
                            ]);

                            $auction_condition->save();
                        }

                        foreach ($_POST['AuctionTn'] as $key => $tn) {
                            $auction_tn = new AuctionTn();

                            $auction_tn->load(['AuctionTn' => $tn]);
                            $tn_total_sum = $auction_tn->price * $auction_tn->quantity;

                            $auction_tn->auction_id = $model->id;
                            $auction_tn->total_sum = $tn_total_sum > 0 ? $tn_total_sum : 0;

                            $auction_tn->save();
                        }

                        $company_transaction = new CompanyTransaction([
                            'company_id' => $user->company_id,
                            'currency' => $total_block_sum,
                            'type' => CompanyTransaction::TYPE_DEPOSIT,
                            'auction_id' => $model->id,
                            'description' => t(""),
                            'status' => CompanyTransaction::STATUS_SUCCESS
                        ]);

                        if ($company_transaction->save()) {
                            Yii::$app->session->setFlash("success", t("С вашего баланса снято {summa} сум в виде залога.", [
                                'summa' => showPrice($total_block_sum)
                            ]));

                            return $this->redirect(['index']);
                        } else {
                            Yii::$app->session->setFlash("error", t("Не удалось снять залог с вашего баланса."));
                            $model->delete();
                            return $this->redirect(['index']);
                        }
                    }
                } else {
                    Yii::$app->session->setFlash('error', t("Товары или услуги не прошли валидацию"));
                }
            } else {
                Yii::$app->session->setFlash('error', t("Не указаны товары или услуги"));
            }
        }

        return $this->render("add", [
            'model' => $model,
            'tns' => $tns
        ]);
    }

    public function actionSearch($category_id = null, $q)
    {
        $models = Tn::find()->joinWith("tnTranslates")->andWhere([
            'or',
            ['LIKE', "tn_translate.title", $q],
            ['LIKE', "tn.code", $q],
        ])->groupBy("tn.id")->orderBy("tn_translate.title asc");

        if ($category_id) {
            $models->andWhere(['tn.category_id' => $category_id]);
        }

        return $this->renderAjax('_search', [
            'models' => $models->all()
        ]);
    }

    public function actionTnForm($tn_id)
    {
        $model = Tn::findOne($tn_id);

        if (!$model) throw new NotFoundHttpException("Tn not found");

        return $this->renderAjax("_tn-form", [
            'model' => $model
        ]);
    }

    // public function actionTransfer()
    // {
    //     \Yii::$app->response->format = Response::FORMAT_JSON;

    // $models = ClassifierCategory::find()->all();

    // foreach ($models as $model) {
    //     $category = new Category([
    //         'titles' => [
    //             1 => $model->name_ru,
    //             2 => $model->name_uz,
    //             3 => $model->name_en
    //         ]
    //     ]);

    //     if ($category->save()){
    //     }

    // }

    // $models = ClassifierProduct::find()->all();

    // foreach ($models as $model) {
    //     $classifer_category = ClassifierCategory::findOne($model->category_id);

    //     if ($classifer_category) {
    //         $translate = CategoryTranslate::findOne(['title' => $classifer_category->name_uz]);

    //         if ($translate) {
    //             $tn = new Tn([
    //                 'code' => $model->code,
    //                 'category_id' => $translate->category_id,
    //                 'titles' => [
    //                     1 => $model->name_ru,
    //                     2 => $model->name_uz,
    //                     3 => $model->name_en
    //                 ]
    //             ]);

    //             $tn->save();
    //         }
    //     }
    // }
    // }
}
