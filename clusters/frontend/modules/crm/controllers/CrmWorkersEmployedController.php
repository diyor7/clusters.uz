<?php

namespace frontend\modules\crm\controllers;

use Yii;
use common\models\crm\CrmWorkersEmployed;
use common\models\crm\CrmWorkersEmployedSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CrmWorkersEmployedController implements the CRUD actions for CrmWorkersEmployed model.
 */
class CrmWorkersEmployedController extends Controller
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
     * Lists all CrmWorkersEmployed models.
     * @return mixed
     */
    public function actionIndex($type_id)
    {
        $searchModel = new CrmWorkersEmployedSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $type_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type_id' => $type_id,
        ]);
    }

    /**
     * Displays a single CrmWorkersEmployed model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $type_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'type_id' => $type_id,
        ]);
    }

    /**
     * Creates a new CrmWorkersEmployed model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type_id)
    {
        $model = new CrmWorkersEmployed();

        if ($model->load(Yii::$app->request->post())) {
            $model->type = $type_id;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id, 'type_id' => $type_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'type_id' => $type_id,
        ]);
    }

    /**
     * Updates an existing CrmWorkersEmployed model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $type_id)
   {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'type_id' => $type_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CrmWorkersEmployed model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $type_id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'type_id' => $type_id]);
    }

    /**
     * Finds the CrmWorkersEmployed model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CrmWorkersEmployed the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CrmWorkersEmployed::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('crm', 'The requested page does not exist.'));
    }
}
