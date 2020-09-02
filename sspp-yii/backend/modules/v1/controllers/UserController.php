<?php


namespace backend\modules\v1\controllers;


use backend\modules\v1\behaviors\BaseHttpBearerAuth;
use backend\modules\v1\controllers\base\BackendBaseController;
use backend\modules\v1\controllers\base\BackendBaseLoginController;
use common\constants\CacheKey;
use common\utils\RedisUtil;
use Yii;

class UserController extends BackendBaseLoginController
{
    public function actionLogout(){
        if (BackendBaseController::LOGIN_TYPE == BackendBaseController::LOGIN_TYPE_REDIS){
            $redis = new RedisUtil();
            $authHeader = Yii::$app->request->getHeaders()->get('Authorization');

            $baseHttpBearerAuth = new BaseHttpBearerAuth();
            $authHeader = Yii::$app->request->getHeaders()->get($baseHttpBearerAuth->header);
            if ($authHeader !== null) {
                if ($baseHttpBearerAuth->pattern !== null) {
                    if (preg_match($baseHttpBearerAuth->pattern, $authHeader, $matches)) {
                        $accessToken = $matches[1];
                        if (!empty($accessToken)) {
//                            $identity = UserAuth::findIdentityByAccessToken($accessToken);
//                            if (!empty($identity)) {
//                                $this->identity = $identity;
//                            }

                            $redis->del(CacheKey::getadminTokenKey($accessToken));
                        }
                    }
                }
            }
        }else{
            Yii::$app->user->logout();
        }

        return '退出成功';
    }
}