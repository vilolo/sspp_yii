<?php

namespace backend\modules\v1\behaviors;

use common\error\ErrorCode;
use common\error\ErrorMsg;
use common\models\User;
use yii\filters\auth\HttpBearerAuth;
use yii\web\UnauthorizedHttpException;

class BaseHttpBearerAuth extends HttpBearerAuth
{
    public $from; //来源，当前behaviors在哪里使用

    public function authenticate($user, $request, $response){
        if(empty($this->from->identity) || $this->from->identity instanceof User) {
            //ApiLoginController验证
            try {
                $identity = parent::authenticate($user, $request, $response);

                if ($identity === null) {
                    throw new UnauthorizedHttpException(ErrorMsg::getErrMsg(ErrorCode::ERR_ACCESS_TOKEN_ERROR), ErrorCode::ERR_ACCESS_TOKEN_ERROR);
                }
                $this->from->identity = $identity;

            } catch (UnauthorizedHttpException $e) {
                throw new UnauthorizedHttpException(ErrorMsg::getErrMsg(ErrorCode::ERR_ACCESS_TOKEN_ERROR), ErrorCode::ERR_ACCESS_TOKEN_ERROR);
            }
        }

        //检验账号状态
//        $userRepository = new UserRepository();
//        $user = $userRepository->getUserById($this->from->identity->user_id);
//        if($user === ErrorCode::ERROR){
//            throw new Exception($userRepository->getErrMsg(),$userRepository->getErrCode());
//        }
//        if($user['state'] == User::USER_STATE_DISABLE){
//            throw new Exception('该账号已被禁用',ErrorCode::ERR_SERVER_ERROR);
//        }

        return $this->from->identity;
    }
}