<?php
namespace frontend\widgets;

class MyPagination extends \yii\bootstrap\Widget
{
    public $pages;
    public $count;

    public function init(){}

    public function run()
    {
        return $this->render('pagination/index', [
            'pages' => $this->pages,
            'count' => $this->count
        ]);
    }
}