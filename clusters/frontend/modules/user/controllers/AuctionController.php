<?php

namespace frontend\modules\user\controllers;

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

class AuctionController extends FrontendController
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

        return $this->render('my-lots-trades', [
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

        return $this->render('my-lots-trades', [
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
            if (!CompanyTransaction::findOne(['company_id' => $user->company_id, 'auction_id' => $model->id, 'type' => CompanyTransaction::TYPE_ZALOG])) {
                $total_block_sum = $model->total_sum * 3.15 / 100;

                $company_transaction = new CompanyTransaction([
                    'company_id' => $user->company_id,
                    'currency' => $total_block_sum,
                    'type' => CompanyTransaction::TYPE_ZALOG,
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

        $tovars = [];

        if ($model->load($_POST) && $model->validate()) {

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

                $deposit_percentage = isset(Yii::$app->params['deposit_percentage']) ? Yii::$app->params['deposit_percentage'] : 3;
                $commission_percentage = isset(Yii::$app->params['commission_percentage']) ? Yii::$app->params['commission_percentage'] : 0.15;

                $kommisiya = $model->total_sum * $commission_percentage / 100;
                $zalog = $model->total_sum * $deposit_percentage / 100;

                $total_block_sum = $kommisiya + $zalog;

                if ($user->availableBalance < $total_block_sum) { // Недостаточно средств 
                    Yii::$app->session->setFlash('danger', t("Недостаточно средств на вашем балансе в системе"));
                    return $this->redirect(['add']);
                }

                if (count($tovars) === count($_POST['AuctionCategory'])) {
                    if ($model->save()) {

                        $condition_inputs = isset($_POST['condition_inputs']) ? $_POST['condition_inputs'] : null;

                        foreach ($model->condition_ids as $condition_id) {
                            $input = [];

                            if($condition_inputs and is_array($condition_inputs) and count($condition_inputs) > 0 && isset($condition_inputs[$condition_id])){
                                $input = $condition_inputs[$condition_id];
                            }

                            $auction_condition = new AuctionCondition([
                                'auction_id' => $model->id,
                                'condition_id' => $condition_id,
                                'own' => "0",
                                'texts' => Condition::findOne($condition_id)->title,
                                'inputs' => json_encode($input)
                            ]);
                            $auction_condition->save();

                        }

                        foreach ($_POST['AuctionCategory'] as $key => $category) {
                            $auction_category = new AuctionCategory();

                            $auction_category->load(['AuctionCategory' => $category]);
                            $category_total_sum = $auction_category->price * $auction_category->quantity;

                            $auction_category->auction_id = $model->id;
                            $auction_category->total_sum = $category_total_sum > 0 ? $category_total_sum : 0;

                            $auction_category->save();
                        }

                        $zalog_transaction = new CompanyTransaction([
                            'company_id' => Yii::$app->user->identity->company_id,
                            'status' => CompanyTransaction::STATUS_SUCCESS,
                            'type' => CompanyTransaction::TYPE_ZALOG,
                            'auction_id' => $model->id,
                            'currency' => $zalog,
                            'description' => t("")
                        ]);

                        $kommision_block_transaction = new CompanyTransaction([
                            'company_id' => Yii::$app->user->identity->company_id,
                            'status' => CompanyTransaction::STATUS_SUCCESS,
                            'type' => CompanyTransaction::TYPE_BLOCK_COMMISION,
                            'auction_id' => $model->id,
                            'currency' => $kommisiya,
                            'description' => t("")
                        ]);

                        if ($zalog_transaction->save() && $kommision_block_transaction->save()) {

                            Yii::$app->session->setFlash("info", t("С вашего баланса снято {zalog} сум в виде залога и {kommisiya} сум в виде комиссионой выплаты.", [
                                'zalog' => showPrice($zalog),
                                'kommisiya' => showPrice($kommisiya)
                            ]));

                            return $this->redirect(['my-lots']);
                        } else {
                            Yii::$app->session->setFlash("error", t("Не удалось снять залог с вашего баланса."));
                            $model->delete();
                            return $this->redirect(['my-lots']);
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



    public function actionUpdate($id)
    {
        // var_dump($_POST); die;
        $user = User::findOne(Yii::$app->user->id);

        $model = Auction::findOne([
            'company_id' => \Yii::$app->user->identity->company_id,
            'status' => Auction::STATUS_MODERATING,
            'id' => $id
        ]);
        // var_dump($model); die;
        if (!$model) throw new NotFoundHttpException("Auksion moderatsiya holatida emas");
        $tovars = [];
        $new_tovars = [];

        if($model->auctionCategories && count($model->auctionCategories) > 0){
            $tovars = $model->auctionCategories;
        }


        if ($model->load($_POST) && $model->validate()) {

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

                        $new_tovars[] = $auction_category;
                    } 
                    
                }

                // $model->company_id = \Yii::$app->user->identity->company_id;
                // $model->status = Auction::STATUS_MODERATING;
                $model->total_sum = $auction_total_sum;
                $model->auction_end = date("Y-m-d", strtotime("+10 days"));

                $deposit_percentage = isset(Yii::$app->params['deposit_percentage']) ? Yii::$app->params['deposit_percentage'] : 3;
                $commission_percentage = isset(Yii::$app->params['commission_percentage']) ? Yii::$app->params['commission_percentage'] : 0.15;

                $kommisiya = $model->total_sum * $commission_percentage / 100;
                $zalog = $model->total_sum * $deposit_percentage / 100;

                $total_block_sum = $kommisiya + $zalog;

                $is_reverted = false;


                $zalog_old_transaction = CompanyTransaction::findOne([
                    'company_id' => Yii::$app->user->identity->company_id,
                    'status' => CompanyTransaction::STATUS_SUCCESS,
                    'type' => CompanyTransaction::TYPE_ZALOG,
                    'auction_id' => $model->id,
                    'reverted_id' => null
                ]);

                $kom_block_trans_old = CompanyTransaction::findOne([
                    'company_id' => Yii::$app->user->identity->company_id,
                    'status' => CompanyTransaction::STATUS_SUCCESS,
                    'type' => CompanyTransaction::TYPE_BLOCK_COMMISION,
                    'auction_id' => $model->id,
                    'reverted_id' => null
                ]);

                if($zalog_old_transaction && $zalog_old_transaction->currency != $zalog && $kom_block_trans_old && $kom_block_trans_old->currency != $kommisiya){
                    
                    $is_reverted = true;
                    
                    if (($user->availableBalance + $zalog_old_transaction->currency + $kom_block_trans_old->currency) < $total_block_sum) { // Недостаточно средств 
                        Yii::$app->session->setFlash('danger', t("Недостаточно средств на вашем балансе в системе"));
                        return $this->redirect(['my-lots']);
                    }
                }

                if (count($new_tovars) === count($_POST['AuctionCategory'])) {
                    if ($model->save()) {

                        AuctionCondition::deleteAll(['auction_id' => $model->id]);
                        AuctionCategory::deleteAll(['auction_id' => $model->id]);

                        $condition_inputs = isset($_POST['condition_inputs']) ? $_POST['condition_inputs'] : null;

                    //    echo "<pre>";
                    //     var_dump($model->condition_ids);
                    //     echo "<br>";
                    //     echo "<br>";
                    //    var_dump($_POST['condition_inputs']);
                    //    die;

                        foreach ($model->condition_ids as $condition_id) {
                            $input = "";

                            if($condition_inputs and is_array($condition_inputs) and count($condition_inputs) > 0 && $condition_inputs[$condition_id]){
                                $input = $condition_inputs[$condition_id];
                            }

                            $auction_condition = new AuctionCondition([
                                'auction_id' => $model->id,
                                'condition_id' => $condition_id,
                                'own' => "0",
                                'texts' => Condition::findOne($condition_id)->title,
                                'inputs' => json_encode($input)
                            ]);
                            $auction_condition->save();
                            //if(!$auction_condition->save()){ var_dump($auction_condition->errors); die; }
                        }

                        foreach ($_POST['AuctionCategory'] as $key => $category) {
                            $auction_category = new AuctionCategory();

                            $auction_category->load(['AuctionCategory' => $category]);
                            $category_total_sum = $auction_category->price * $auction_category->quantity;

                            $auction_category->auction_id = $model->id;
                            $auction_category->total_sum = $category_total_sum > 0 ? $category_total_sum : 0;

                            $auction_category->save();
                        }
                        
                        
                        /**
                         * eski zalogni currency qiymati yangi bilan mos bo'lmasa : 
                         * 
                        */

                        if($is_reverted){
                            $zalog_transaction_revert = new CompanyTransaction([
                                'company_id' => Yii::$app->user->identity->company_id,
                                'status' => CompanyTransaction::STATUS_SUCCESS,
                                'type' => CompanyTransaction::TYPE_REVERT_ZALOG,
                                'auction_id' => $model->id,
                                'currency' => $zalog_old_transaction->currency,
                                'description' => t(""),
                            ]);
                            if($zalog_transaction_revert->save()){
                                $zalog_old_transaction->reverted_id = $zalog_transaction_revert->id;
                                $zalog_old_transaction->save(false);
                                
                                /*
                                * new insert
                                */
                                $zalog_transaction = new CompanyTransaction([
                                    'company_id' => Yii::$app->user->identity->company_id,
                                    'status' => CompanyTransaction::STATUS_SUCCESS,
                                    'type' => CompanyTransaction::TYPE_ZALOG,
                                    'auction_id' => $model->id,
                                    'currency' => $zalog,
                                    'description' => t("")
                                ]);

                            }

                            /**
                             *  komissiya
                            */

                            $kom_block_trans_revert = new CompanyTransaction([
                                'company_id' => Yii::$app->user->identity->company_id,
                                'status' => CompanyTransaction::STATUS_SUCCESS,
                                'type' => CompanyTransaction::TYPE_REVERT_BLOCK_COMMISION,
                                'auction_id' => $model->id,
                                'currency' => $kom_block_trans_old->currency,
                                'description' => t(""),
                            ]);
                            if($kom_block_trans_revert->save()){
                                $kom_block_trans_old->reverted_id = $kom_block_trans_revert->id;
                                $kom_block_trans_old->save(false);

                                /**
                                 * new insert
                                 */

                                $kommision_block_transaction = new CompanyTransaction([
                                    'company_id' => Yii::$app->user->identity->company_id,
                                    'status' => CompanyTransaction::STATUS_SUCCESS,
                                    'type' => CompanyTransaction::TYPE_BLOCK_COMMISION,
                                    'auction_id' => $model->id,
                                    'currency' => $kommisiya,
                                    'description' => t("")
                                ]);
                            }

                            if ($zalog_transaction->save() && $kommision_block_transaction->save()) {

                                Yii::$app->session->setFlash("info", t("С вашего баланса снято {zalog} сум в виде залога и {kommisiya} сум в виде комиссионой выплаты.", [
                                    'zalog' => showPrice($zalog),
                                    'kommisiya' => showPrice($kommisiya)
                                ]));
    
                                return $this->redirect(['my-lots']);
                            } else {
                                Yii::$app->session->setFlash("error", t("Не удалось снять залог с вашего баланса."));
                                $model->delete();
                                return $this->redirect(['my-lots']);
                            }

                        } else {
                            Yii::$app->session->setFlash("info", t("Данные успешно изменены."));
                            return $this->redirect(['my-lots']);
                        }
                    }
                } else {
                    Yii::$app->session->setFlash('error', t("Товары или услуги не прошли валидацию"));
                }
            } else {
                Yii::$app->session->setFlash('error', t("Не указаны товары или услуги"));
            }
        }

        return $this->render("update", [
            'model' => $model,
            'tovars' => $tovars
        ]);
    }

    public function actionSearch($category_id = null, $q)
    {
        // $models = Tn::find()->joinWith("tnTranslates")->andWhere([
        //     'or',
        //     ['LIKE', "tn_translate.title", $q],
        //     ['LIKE', "tn.code", $q],
        // ])->groupBy("tn.id")->orderBy("tn_translate.title asc");

        // if ($category_id) {
        //     $models->andWhere(['tn.category_id' => $category_id]);
        // }

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
