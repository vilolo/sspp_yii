<?php


namespace backend\controllers;


use common\constants\ResCode;
use common\utils\JsonUtil;
use Yii;
use yii\web\ErrorAction;
use yii\web\Response;

class ErrAction extends ErrorAction
{
    public function run()
    {
        // 根据异常类型设定相应的响应码
        Yii::$app->getResponse()->setStatusCodeByException($this->exception);
        // json 格式返回
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;
        // 返回的内容数据
        return JsonUtil::error(ResCode::getMessageByCode($this->exception->statusCode)??$this->exception->getMessage(), $this->exception->statusCode);
    }
}