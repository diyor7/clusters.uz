<?php

namespace frontend\widgets;

use yii\base\Widget;

class SimpleAlert extends Widget {

    public function run (){
        return $this->render("simple-alert/index");
    }
}