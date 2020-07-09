<?php


namespace backend\modules\v1\controllers\base;


class LoginController extends BackendBaseController
{
    public function actionLogin(){
        if ($this->loginType == self::LOGIN_TYPE_REDIS){
            $res = $this->loginRedis();
        }else{
            $res = $this->loginSession();
        }
        return $res;
    }

    private function loginRedis(){

    }

    private function loginSession(){

    }


}