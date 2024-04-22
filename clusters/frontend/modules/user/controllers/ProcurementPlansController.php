<?php

namespace frontend\modules\user\controllers;

use common\models\Company;
use Yii;
use common\models\ProcurementPlan;
use common\models\ProcurementPlanSearch;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProcurementPlansController implements the CRUD actions for ProcurementPlan model.
 */
class ProcurementPlansController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProcurementPlan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $models = ProcurementPlan::find()->where(['company_id' => Yii::$app->user->identity->company_id]);

        $pages = new Pagination([
            'totalCount' => $models->count(),
            'defaultPageSize' => 15
        ]);

        $models->limit($pages->limit)->offset($pages->offset);

        return $this->render('index', [
            'models' => $models->all(),
            'pages' => $pages
        ]);
    }

    /**
     * Displays a single ProcurementPlan model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProcurementPlan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProcurementPlan();
        $company = Company::findOne(Yii::$app->user->identity->company_id);
        $model->company_id = $company->id;
        if ($company->type == Company::TYPE_BUDGET) {
            $model->type = ProcurementPlan::TYPE_BUDJET;
        } elseif ($company->type == Company::TYPE_COPERATE) {
            $model->type = ProcurementPlan::TYPE_KORPORATIV;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProcurementPlan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->company_id != Yii::$app->user->identity->company_id) return $this->redirect(['index']);
        // if ($model->created_at + 24 * 3600 < time()) {
        //     return 'Срок для изменения окончен: срок для изменения 24 часа, после добавления!';
        // }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        $model->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the ProcurementPlan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProcurementPlan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProcurementPlan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
