<?php

namespace backend\modules\v1\behavior;

use common\error\ErrorCode;
use common\error\ErrorMsg;
use yii\filters\auth\HttpBearerAuth;
use yii\web\UnauthorizedHttpException;

class BaseHttpBearerAuth extends HttpBearerAuth
{
    public $from; //来源，当前behaviors在哪里使用

    public function authenticate($user, $request, $response){
        throw new UnauthorizedHttpException(ErrorMsg::getErrMsg(ErrorCode::ERR_ACCESS_TOKEN_ERROR), ErrorCode::ERR_ACCESS_TOKEN_ERROR);
        return $this->from->identity = ['id' => 666];
    }
}