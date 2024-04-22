<?php

namespace frontend\widgets;

use yii\base\Widget;


class MyAlert extends Widget {

    public function run (){
        return $this->render("myalert/index");
    }
}