<?php


namespace backend\modules\v1\controllers\basic;


use backend\modules\v1\controllers\base\BackendBaseController;
use common\utils\JsonUtil;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class TestController extends BackendBaseController
{
    public function actionIndex(){
        xx
        throw new BadRequestHttpException('aa', 333);
    }
}