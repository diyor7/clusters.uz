<?php

namespace frontend\controllers;

use common\models\Company;
use common\models\CompanyTransaction;
use common\models\Forum;
use common\models\ForumSearch;
use common\models\Page;
use common\models\PageTranslate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\web\UploadedFile;
use common\models\News;

class PageController extends FrontendController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionConference()
    {
        $model = Page::findOne(40);
        return $this->render('conference', [
            'model' => $model
        ]);
    }

    public function actionConferenceList()
    {
        $searchModel  = new ForumSearch();
        $dataProvider = $searchModel->search($_GET);

        return $this->render('forum_list', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionExport(){
        set_time_limit(0);

        $products = Forum::find()->all();

        $objPHPExcel = new Spreadsheet();
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(18);

        $objPHPExcel->getActiveSheet()->getStyle("A1:X1")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->setCellValue('A' . 1, "№");
        $objPHPExcel->getActiveSheet()->setCellValue('B' . 1, "Имя");
        $objPHPExcel->getActiveSheet()->setCellValue('C' . 1, "Фамилия");
        $objPHPExcel->getActiveSheet()->setCellValue('D' . 1, "Эл. адрес");
        $objPHPExcel->getActiveSheet()->setCellValue('E' . 1, "Номер телефона");
        $objPHPExcel->getActiveSheet()->setCellValue('F' . 1, "Организация");
        $objPHPExcel->getActiveSheet()->setCellValue('G' . 1, "Занятие");
        $objPHPExcel->getActiveSheet()->setCellValue('H' . 1, "Панел");
        $objPHPExcel->getActiveSheet()->setCellValue('I' . 1, "Тема");
        $objPHPExcel->getActiveSheet()->setCellValue('J' . 1, "Страна");
        $objPHPExcel->getActiveSheet()->setCellValue('K' . 1, "*");
        $row = 2;
        foreach ($products as $model) {

            $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $row-1);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $model->first_name);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $model->last_name);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $model->email);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $model->phone);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $model->organization);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $model->occupation);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $model->panel);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $model->theme);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $model->country);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, Forum::getTypeWhoIs($model->who_is));

            $row++;
        }
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');

        $base_directory = \Yii::getAlias('@frontend/web/excels/');

        $folder = '/' . date('Y') . '/' . date('m') . '/' . date('d');
        $new_directory = $base_directory . '/' . $folder;

        if (!file_exists($new_directory)) {
            mkdir($new_directory, 0777, true);
        }

        $file_dir = $new_directory . '/' . "pro-" . time() . '.xlsx';
        $writer->save($file_dir);

        if (file_exists($file_dir)) {
            return \Yii::$app->response->sendFile($file_dir);
        }
    }

    public function actionForum(){
        $model = new Forum();

        try {
            if ($model->load($_POST) && $model->save()) {

                \Yii::$app->session->setFlash(
                    'success',
                    t('Данные получены. Спасибо.')
                );

                return $this->redirect(['conference']);
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
            $model->addError('_exception', $msg);
        }

        return $this->render('forum', ['model' => $model]);
    }

    public function actionDocuments()
    {
        return $this->render("documents");
    }

    public function actionNews()
    {
        $models = News::find()->orderBy('created_at desc');

        $pages = new Pagination([
            'totalCount' => $models->count(),
            'defaultPageSize' => 12
        ]);

        $models = $models->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render("news", [
            'models' => $models,
            'pages' => $pages
        ]);
    }

    public function actionNew($url, $id)
    {
        $model = News::findOne($id);
        $models = News::find()->where(['not in','id', $id])->orderBy('created_at desc')->limit(4)->all();

        if (!$model)
            throw new NotFoundHttpException(t("Страница не найдена"));

        $model->views = $model->views + 1;
        $model->save();

        return $this->render('new', [
            'model' => $model,
            'models' => $models,
        ]);
    }

    public function actionContact()
    {
        return $this->render("contact");
    }

    public function actionView($url)
    {
        $pageTranslate = PageTranslate::findOne(['url' => $url]);

        if (!$pageTranslate)
            throw new NotFoundHttpException(t("Страница не найдена"));

        return $this->render('view', [
            'page' => $pageTranslate->page
        ]);
    }
}
