<?php

namespace backend\modules\v1\controllers;


use backend\modules\v1\controllers\base\BackendBaseController;

class DemoController extends BackendBaseController
{
    public function actionIndex(){
        echo 'okok';
    }
}