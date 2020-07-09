<?php

namespace backend\modules\v1\controllers;


use backend\modules\v1\controllers\base\BackendBaseLoginController;

class DemoController extends BackendBaseLoginController
{
    public function actionIndex(){
        return $this->identity['username'];
    }
}