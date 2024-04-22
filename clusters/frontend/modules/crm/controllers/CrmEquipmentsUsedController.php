<?php

namespace frontend\modules\crm\controllers;

use Yii;
use common\models\crm\CrmEquipmentsUsed;
use common\models\crm\CrmEquipmentsUsedSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CrmEquipmentsUsedController implements the CRUD actions for CrmEquipmentsUsed model.
 */
class CrmEquipmentsUsedController extends Controller
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
     * Lists all CrmEquipmentsUsed models.
     * @return mixed
     */
    public function actionIndex($type_id)
    {
        $searchModel = new CrmEquipmentsUsedSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $type_id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type_id' => $type_id,
        ]);
    }

    /**
     * Displays a single CrmEquipmentsUsed model.
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
     * Creates a new CrmEquipmentsUsed model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type_id)
    {
        $model = new CrmEquipmentsUsed();

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
     * Updates an existing CrmEquipmentsUsed model.
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
     * Deletes an existing CrmEquipmentsUsed model.
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
     * Finds the CrmEquipmentsUsed model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CrmEquipmentsUsed the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CrmEquipmentsUsed::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('crm', 'The requested page does not exist.'));
    }
}
