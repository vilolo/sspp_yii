<?php


namespace common\exception;

use common\constants\ResCode;
use yii\base\ErrorHandler as BaseErrorHandler;
class CommonHandler extends BaseErrorHandler
{

    protected function renderException($exception)
    {
        $code = $exception->getCode() == 0 ? $exception->statusCode : $exception->getCode();
        $returnData = [
            'code' => $code??500, //业务码
            'message' => ResCode::getMessageByCode($code)?ResCode::getMessageByCode($code):$exception->getMessage(), //提示信息
            'data' => [], //业务数据
            'status' => ResCode::SUCCESS//http状态码
        ];
        exit( json_encode($returnData));
    }
}