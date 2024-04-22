<?php

namespace frontend\modules\cabinet\controllers;

use common\models\CompanyTn;
use common\models\Product;
use common\models\ProductImage;
use common\models\User;
use frontend\controllers\FrontendController;
use Yii;
use yii\data\Pagination;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ProductController extends FrontendController
{
    public function actionIndex()
    {
        $user = User::findOne(Yii::$app->user->id);

        $products = Product::find()->where(['company_id' => $user->company_id, 'status' => Product::STATUS_ACTIVE])->orderBy('id desc');

        $pages = new Pagination([
            'totalCount' => $products->count(),
            'defaultPageSize' => 9
        ]);

        $products->offset($pages->offset)->limit($pages->limit);

        return $this->render('index', [
            'user' => $user,
            'products' => $products->all(),
            'tab' => Product::STATUS_ACTIVE,
            'pages' => $pages,
            'counts' => $this->getStatusCounts()
        ]);
    }

    public function actionArchive()
    {
        $user = User::findOne(Yii::$app->user->id);

        $products = Product::find()->where(['company_id' => $user->company_id, 'status' => Product::STATUS_INACTIVE])->orderBy('id desc');

//        $pages = new Pagination([
//            'totalCount' => $products->count(),
//            'defaultPageSize' => 9
//        ]);

//        $products->offset($pages->offset)->limit($pages->limit);

        return $this->render('archive', [
            'user' => $user,
            'products' => $products->all(),
            'tab' => Product::STATUS_INACTIVE,
//            'pages' => $pages,
            'counts' => $this->getStatusCounts()
        ]);
    }

    public function actionSetActive($id)
    {
        $user = User::findOne(Yii::$app->user->id);

        $products = Product::find()->where(['company_id' => $user->company_id, 'status' => Product::STATUS_INACTIVE, 'id' => $id])->one();
        if($products){
            $products->status = Product::STATUS_ACTIVE;
            $products->time_to_archive = date("Y-m-d H:i:s", strtotime(\Yii::$app->params['product_archive_days'] . " days"));
            if($products->save(false)){
                Yii::$app->session->setFlash('success', t("Успешно!"));
            } else {
                Yii::$app->session->setFlash('danger', t("Неудачный"));
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSetActiveSome()
    {
        $user = User::findOne(Yii::$app->user->id);

        if (Yii::$app->request->isPost) {
            $product_ids = isset($_POST['ProductArchives']) ? $_POST['ProductArchives'] : [];
            if(count($product_ids) > 0){

                foreach ($product_ids as $p_id){
                    $model = Product::find()->where(['company_id' => $user->company_id, 'status' => Product::STATUS_INACTIVE, 'id' => $p_id])->one();
                    $model->status = Product::STATUS_ACTIVE;
                    $model->time_to_archive = date("Y-m-d H:i:s", strtotime(\Yii::$app->params['product_archive_days'] . " days"));
                    $model->save(false);
                }

                Yii::$app->session->setFlash('success', t("Успешно!"));
            } else {
                Yii::$app->session->setFlash('danger', t("Выберите продукт"));
            }

            return $this->redirect(Yii::$app->request->referrer);
        }

        Yii::$app->session->setFlash('danger', t("Выберите продукт"));
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSetArchive($id)
    {
        $user = User::findOne(Yii::$app->user->id);

        $products = Product::find()->where(['company_id' => $user->company_id, 'status' => Product::STATUS_ACTIVE, 'id' => $id])->one();
        if($products){
            $products->status = Product::STATUS_INACTIVE;
            $products->time_to_archive = '0000-00-00 00:00:00';
            if($products->save(false)){
                Yii::$app->session->setFlash('success', t("Успешно!"));
            } else {
                Yii::$app->session->setFlash('danger', t("Неудачный"));
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionModerating()
    {
        $user = User::findOne(Yii::$app->user->id);

        $products = Product::find()->where(['company_id' => $user->company_id, 'status' => [Product::STATUS_MODERATING, Product::STATUS_MODERATING_AGAIN, Product::STATUS_BALANCE_WAITING_TILL_MODERATING]])->orderBy('id desc');

        $pages = new Pagination([
            'totalCount' => $products->count(),
            'defaultPageSize' => 9
        ]);

        $products->offset($pages->offset)->limit($pages->limit);

        return $this->render('index', [
            'user' => $user,
            'products' => $products->all(),
            'tab' => Product::STATUS_MODERATING,
            'pages' => $pages,
            'counts' => $this->getStatusCounts()
        ]);
    }

    public function actionNotModerated()
    {
        $user = User::findOne(Yii::$app->user->id);

        $products = Product::find()->where(['company_id' => $user->company_id, 'status' => [Product::STATUS_NOT_MODERATED]])->orderBy('id desc');

        $pages = new Pagination([
            'totalCount' => $products->count(),
            'defaultPageSize' => 9
        ]);

        $products->offset($pages->offset)->limit($pages->limit);

        return $this->render('index', [
            'user' => $user,
            'products' => $products->all(),
            'tab' => Product::STATUS_NOT_MODERATED,
            'pages' => $pages,
            'counts' => $this->getStatusCounts()
        ]);
    }

    public function actionTn()
    {
        $user = User::findOne(Yii::$app->user->id);

        $tns = CompanyTn::find()->where(['company_id' => $user->company_id])->all();

        return $this->render('tn', [
            'tns' => $tns,
            'counts' => $this->getStatusCounts()
        ]);
    }

    public function actionHandle($id = null)
    {
        $user = User::findOne(Yii::$app->user->id);

        $model = null;

        if ($id) {
            $model = Product::findOne(['id' => $id, 'company_id' => $user->company_id]);

            if (!$model) throw new NotFoundHttpException(t("Товар не найден"));
        } else {
            $model = new Product([
                'company_id' => $user->company_id,
                'status' => Product::STATUS_BALANCE_WAITING_TILL_MODERATING,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'scenario' => "create",
                "time_to_archive" => '0000-00-00 00:00:00'
            ]);
        }

        $model->scenario = 'seller';

        if ($model->load($_POST) && $model->validate()) {
            if ($model->status == Product::STATUS_ACTIVE && !$model->isNewRecord)
                $model->status = Product::STATUS_MODERATING_AGAIN;
            else if ($model->status == Product::STATUS_ACTIVE && $model->isNewRecord)
                $model->status = Product::STATUS_BALANCE_WAITING_TILL_MODERATING;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', t("Товар успешно сохранён."));

                return $this->redirect(['index']);
            }
        }

        return $this->render('handle', [
            'user' => $user,
            'model' => $model
        ]);
    }

    public function actionAddTn($id = null)
    {
        $user = User::findOne(Yii::$app->user->id);

        $model = null;

        if ($id) {
            $model = CompanyTn::findOne(['id' => $id, 'company_id' => $user->company_id]);

            if (!$model) throw new NotFoundHttpException(t("ТН ВЭД не найден"));
        } else {
            $model = new CompanyTn([
                'company_id' => $user->company_id,
                'status' => CompanyTn::STATUS_MODERATING,
            ]);
        }

        if ($model->load($_POST) && $model->validate()) {
            $model->status = CompanyTn::STATUS_MODERATING;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', t("ТН ВЭД успешно сохранён."));

                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->render('add-tn', [
            'user' => $user,
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        $user = User::findOne(Yii::$app->user->id);

        $product = Product::findOne(['id' => $id, 'company_id' => $user->company_id]);

        if (!$product) {
            throw new NotFoundHttpException(t("Товар не найден"));
        }

        if ($product->delete() !== false) {
            Yii::$app->session->setFlash("success", t("Товар успешно удален."));
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    private function getStatusCounts()
    {
        return ArrayHelper::map((new Query())->select('status, count(*) as count')->from('product')
            ->where(['company_id' => Yii::$app->user->identity->company_id])->groupBy('status')->all(), 'status', 'count');
    }

    public function actionDeleteProductImage($product_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = Product::findOne(['id' => $product_id, 'company_id' => Yii::$app->user->identity->company_id]);

        if (!$model) throw new NotFoundHttpException("Product not found");

        $model->deleteFile($model->image);
        $model->image = null;
        $model->save();

        return [
            'status' => "success"
        ];
    }

    public function actionDeleteImage($image_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = ProductImage::find()->joinWith("product")->where(['product.company_id' => Yii::$app->user->identity->company_id, 'product_image.id' => $image_id])->one();

        if (!$model) throw new NotFoundHttpException("Product not found");

        $model->product->deleteFile($model->filename);
        $model->delete();

        return [
            'status' => "success"
        ];
    }
}
