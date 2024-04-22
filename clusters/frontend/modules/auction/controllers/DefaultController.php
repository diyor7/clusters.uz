<?php

namespace frontend\modules\auction\controllers;

use common\models\Auction;
use common\models\AuctionCondition;
use common\models\AuctionRequest;
use common\models\AuctionCategory;
use common\models\Category;
use common\models\CompanyTransaction;
use common\models\Condition;
use common\models\User;
use frontend\controllers\FrontendController;
use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class DefaultController extends FrontendController
{
    public function actionIndex($name = null, $region_id = null, $summa_from = null, $summa_to = null, $tovar_id = null, $auction_end = null)
    {
        $models = Auction::find()->where(['auction.status' => Auction::STATUS_ACTIVE])->joinWith("auctionCategories.category.categoryTranslates")->orderBy("auction.id desc");
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
                ['like', 'category_translate.title', $name]
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

        if ($tovar_id) {
            $models->andWhere(['auction_category.category_id' => $tovar_id]);
            $is_open = true;
        }

        if ($auction_end) {
            $models->andWhere(['DATE(auction.auction_id)' => $auction_end]);
            $is_open = true;
        }

        return $this->render('index', [
            'models' => $models->all(),
            'title' => t("Аукцион"),
            'pages' => $pages,
            'is_open' => $is_open,
            'name' => $name,
            'region_id' => $region_id,
            'summa_from' => $summa_from,
            'summa_to' => $summa_to,
            'tovar_id' => $tovar_id,
            'auction_end' => $auction_end
        ]);
    }

    public function actionMyLots($name = null, $region_id = null, $summa_from = null, $summa_to = null, $tovar_id = null, $auction_end = null)
    {
        $user = User::findOne(Yii::$app->user->id);
        $models = Auction::find()->joinWith("auctionCategories.category.categoryTranslates")->orderBy("auction.id desc");

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

        if ($tovar_id) {
            $models->andWhere(['auction_categroy.category_id' => $tovar_id]);
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
            'tovar_id' => $tovar_id,
            'auction_end' => $auction_end

        ]);
    }

    public function actionMyTrades($name = null, $region_id = null, $summa_from = null, $summa_to = null, $tovar_id = null, $auction_end = null)
    {
        $user = User::findOne(Yii::$app->user->id);
        $models = Auction::find()->joinWith("auctionCategories.category.categoryTranslates")->orderBy("auction.id desc");

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

        if ($tovar_id) {
            $models->andWhere(['auction_category.category_id' => $tovar_id]);
            $is_open = true;
        }

        if ($auction_end) {
            $models->andWhere(['DATE(auction.auction_id)' => $auction_end]);
            $is_open = true;
        }

        return $this->render('index', [
            'models' => $models->all(),
            'title' => t("Мои сделки"),
            'pages' => $pages,
            'is_open' => $is_open,
            'name' => $name,
            'region_id' => $region_id,
            'summa_from' => $summa_from,
            'summa_to' => $summa_to,
            'tovar_id' => $tovar_id,
            'auction_end' => $auction_end
        ]);
    }

    public function actionView($id)
    {
        $model = Auction::findOne(['id' => $id, 'status' => [Auction::STATUS_ACTIVE, Auction::STATUS_FINISHED]]);
        $user = User::findOne(Yii::$app->user->id);

        //        var_dump(($model->auctionConditions));
        //        die;

        if (!$model) throw new NotFoundHttpException("Auction not found");

        $model->views++;
        $model->save();

        $name = "";

        foreach ($model->auctionCategories as $index => $ac) {
            $name .= $ac->category->title . ($index != count($model->auctionCategories) - 1 ? ', ' : '');
        }

        return $this->render("view", [
            'model' => $model,
            'user' => $user,
            'name' => $name
        ]);
    }


    public function actionGetPrices($auctionRequests, $total_sum, $currentPrice, $nextPrice)
    {
        return $this->renderAjax('_price_box', [
            'auctionRequests' => $auctionRequests,
            'total_sum' => $total_sum,
            'currentPrice' => $currentPrice,
            'nextPrice' => $nextPrice,
        ]);
    }

    public function actionOffer($id, $price)
    {

        if (!Yii::$app->session->has("checked_key") || Yii::$app->session->has("checked_key") && Yii::$app->session->get("checked_key") == false) {
            Yii::$app->session->setFlash("danger", t("Не удалось принять запрос. Не подтверждён ключом."));
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            Yii::$app->session->remove("checked_key");
        }

        $model = Auction::findOne(['id' => $id, 'status' => [Auction::STATUS_ACTIVE, Auction::STATUS_FINISHED]]);
        $user = User::findOne(Yii::$app->user->id);

        if ($model->status == Auction::STATUS_FINISHED) {
            Yii::$app->session->setFlash("error", t("Аукцион уже закончился."));
            return $this->redirect(Yii::$app->request->referrer);
        }

        if (!$model) {
            throw new NotFoundHttpException("Auction not found");
        }

        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();

        try {
            $request_is = false;
            $request = new AuctionRequest([
                'company_id' => Yii::$app->user->identity->company_id,
                'auction_id' => $model->id,
                'is_winner' => 0
            ]);

            $next_price = $model->nextPrice;

            if (($request->price = $next_price) == $price and $request->validate()) {

                //                $request->price = $next_price;

                if (!CompanyTransaction::findOne(['company_id' => $user->company_id, 'auction_id' => $model->id, 'type' => CompanyTransaction::TYPE_ZALOG, 'reverted_id' => null]) and !CompanyTransaction::findOne(['company_id' => $user->company_id, 'auction_id' => $model->id, 'type' => CompanyTransaction::TYPE_BLOCK_COMMISION, 'reverted_id' => null])) {

                    $request_is = true;

                    $percentage_block_sum = $model->total_sum * Yii::$app->params['deposit_percentage'] / 100;
                    $company_transaction = new CompanyTransaction([
                        'company_id' => $user->company_id,
                        'currency' => $percentage_block_sum,
                        'type' => CompanyTransaction::TYPE_ZALOG,
                        'auction_id' => $model->id,
                        'description' => t(""),
                        'status' => CompanyTransaction::STATUS_SUCCESS
                    ]);

                    $commission_block_sum = ($next_price / $model->total_sum) * 100 > Yii::$app->params['dumping_percentage'] ? $model->total_sum - $next_price : $model->total_sum * Yii::$app->params['commission_percentage'] / 100;

                    $company_transaction2 = new CompanyTransaction([
                        'company_id' => $user->company_id,
                        'currency' => $commission_block_sum,
                        'type' => CompanyTransaction::TYPE_BLOCK_COMMISION,
                        'auction_id' => $model->id,
                        'description' => t(""),
                        'status' => CompanyTransaction::STATUS_SUCCESS
                    ]);

                    if ($company_transaction->save() && $company_transaction2->save()) {

                        $company_transactions_for_back = CompanyTransaction::find()
                            ->where([
                                'type' => CompanyTransaction::TYPE_ZALOG,
                                'auction_id' => $model->id,
                                'status' => CompanyTransaction::STATUS_SUCCESS,
                                'reverted_id' => null
                            ])
                            ->andWhere(['!=', 'id', $company_transaction->id])
                            ->all();

                        foreach ($company_transactions_for_back as $c_for_back) {
                            $company_transaction_back = new CompanyTransaction([
                                'company_id' => $c_for_back->company_id,
                                'order_id' => $c_for_back->order_id,
                                'currency' => $c_for_back->currency,
                                'type' => CompanyTransaction::TYPE_REVERT_ZALOG,
                                'auction_id' => $model->id,
                                'description' => t(""),
                                'status' => CompanyTransaction::STATUS_SUCCESS
                            ]);
                            if ($company_transaction_back->save()) {
                                $c_for_back->reverted_id = $company_transaction_back->id;
                                if (!$c_for_back->save()) {
                                    $transaction->rollBack();
                                    Yii::$app->session->setFlash("error", t("Не удалось снять средств с вашега баланса."));
                                    return $this->redirect(Yii::$app->request->referrer);
                                }
                            }
                        }


                        $company_transactions_for_back2 = CompanyTransaction::find()
                            ->where([
                                'type' => CompanyTransaction::TYPE_BLOCK_COMMISION,
                                'auction_id' => $model->id,
                                'status' => CompanyTransaction::STATUS_SUCCESS,
                                'reverted_id' => null
                            ])
                            ->andWhere(['!=', 'id', $company_transaction2->id])
                            ->all();

                        foreach ($company_transactions_for_back2 as $c_for_back) {
                            $company_transaction_back2 = new CompanyTransaction([
                                'company_id' => $c_for_back->company_id,
                                'order_id' => $c_for_back->order_id,
                                'currency' => $c_for_back->currency,
                                'type' => CompanyTransaction::TYPE_REVERT_BLOCK_COMMISION,
                                'auction_id' => $model->id,
                                'description' => t(""),
                                'status' => CompanyTransaction::STATUS_SUCCESS
                            ]);
                            if ($company_transaction_back2->save()) {
                                $c_for_back->reverted_id = $company_transaction_back2->id;
                                if (!$c_for_back->save()) {
                                    $transaction->rollBack();
                                    Yii::$app->session->setFlash("error", t("Не удалось снять средств с вашега баланса."));
                                    return $this->redirect(Yii::$app->request->referrer);
                                }
                            }
                        }

                        Yii::$app->session->setFlash("info", t("С вашего баланса снято {summa} сум в виде залога и {summa2} сум за комиссию.", [
                            'summa' => showPrice($percentage_block_sum),
                            'summa2' => showPrice($commission_block_sum),
                        ]));
                    } else {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash("error", t("Не удалось снять средств с вашега баланса."));
                        return $this->redirect(Yii::$app->request->referrer);
                    }
                }

                if ($request_is) {
                    if ($request->save()) {
                        $transaction->commit();
                        Yii::$app->session->setFlash("success", t("Ваш запрос успешно принять"));
                    } else {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash("error", t("Не удалось принять ваш запрос, повторите попытку."));
                    }
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash("error", t("Вы голосовали последним. Попробуйте через некоторое время."));
                }
            } else {
                $transaction->rollBack();
                Yii::$app->session->setFlash("error", t("При обработке вашего запроса другой участник уже снизил цену. {e}"));
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
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

        $tovars = [];


        if ($model->load($_POST) && $model->validate()) {
            //            echo "<pre>";
            //            var_dump($_POST);
            //            die;
            if (isset($_POST['AuctionCategory']) && is_array($_POST['AuctionCategory']) && count($_POST['AuctionCategory']) > 0) {
                $tovars_count = 0;
                $auction_total_sum = 0;

                foreach ($_POST['AuctionCategory'] as $key => $category) {
                    $auction_category = new AuctionCategory();

                    $auction_category->load(['AuctionCategory' => $category]);

                    $category_total_sum = $auction_category->price * $auction_category->quantity;

                    $auction_category->total_sum = $category_total_sum;

                    if ($auction_category->validate()) {
                        $auction_total_sum += ($category_total_sum > 0 ? $category_total_sum : 0);
                        $tovars_count++;
                    }

                    $tovars[] = $auction_category;
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
                //                echo "<pre>";
                //            var_dump($_POST);
                //            echo "<br>";
                //            echo "<br>";
                //                var_dump($_POST['condition_inputs']);
                //                die;

                if (count($tovars) === count($_POST['AuctionCategory'])) {
                    if ($model->save()) {

                        $condition_inputs = $_POST['condition_inputs'];

                        foreach ($model->condition_ids as $condition_id) {
                            $input = $condition_inputs[$condition_id];

                            $auction_condition = new AuctionCondition([
                                'auction_id' => $model->id,
                                'condition_id' => $condition_id,
                                'own' => "0",
                                'texts' => Condition::findOne($condition_id)->title,
                                'inputs' => json_encode($input)
                            ]);
                            $auction_condition->save();
                            //                            if(!$auction_condition->save()){ var_dump($auction_condition->errors); die; }
                        }

                        foreach ($_POST['AuctionCategory'] as $key => $category) {
                            $auction_category = new AuctionCategory();

                            $auction_category->load(['AuctionCategory' => $category]);
                            $category_total_sum = $auction_category->price * $auction_category->quantity;

                            $auction_category->auction_id = $model->id;
                            $auction_category->total_sum = $category_total_sum > 0 ? $category_total_sum : 0;

                            $auction_category->save();
                        }

                        $company_transaction = new CompanyTransaction([
                            'company_id' => $user->company_id,
                            'currency' => $total_block_sum,
                            'type' => CompanyTransaction::TYPE_ZALOG,
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
            'tovars' => $tovars
        ]);
    }

    public function actionSearch($category_id = null, $q)
    {
        $models = Category::find()->joinWith("categoryTranslates")
            ->where(['category.type' => Category::TYPE_EMAGAZIN]);

        $models->andWhere(['parent_id' => $category_id]);

        if ($q) {
            $models->andWhere([
                'or',
                ['like', 'category_translate.title', $q],
                ['like', 'category.id', $q]
            ]);
        }

        $models = $models->groupBy("category.id")->all();

        return $this->renderAjax('_search', [
            'models' => $models
        ]);
    }

    public function actionCategoryForm($category_id)
    {
        $model = Category::findOne($category_id);

        if (!$model) throw new NotFoundHttpException("Category not found");

        return $this->renderAjax("_category-form", [
            'model' => $model
        ]);
    }
}
