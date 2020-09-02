<?php


namespace backend\modules\v1\controllers\basic;


use backend\modules\v1\controllers\base\BackendBaseController;
use common\constants\CacheKey;
use common\constants\ConstantKey;
use common\models\LoginForm;
use common\models\SignupForm;
use common\models\User;
use common\utils\HelperUtil;
use common\utils\RedisUtil;

class UserController extends BackendBaseController
{
    public function actionSignup(){
        $model = new SignupForm();
        if ($model->load(\Yii::$app->request->post()) && $model->signup()){
            echo '注册成功';die();
        }else{
            echo '注册失败';die();
        }
    }

    public function actionLogin(){
        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            $data = ['uid' => \Yii::$app->user->identity['id'],
                'username' => \Yii::$app->user->identity['username']];
            if (self::LOGIN_TYPE == self::LOGIN_TYPE_REDIS){
                $res = $this->loginRedis($data);
            }else{
                $res = $this->loginSession($data);
            }
            return $res;
        } else {
            $model->password = '';
            return '登录失败';
        }
    }

    private function loginRedis($data){
        $accessToken = HelperUtil::getUUID();
        $redis = new RedisUtil();

        $adminObjectArray = User::instance()->findIdentity($data['uid']);
        $expireTime = ConstantKey::ADMIN_TOKEN_EXPIRE_TIME;
        $redis->setex(CacheKey::getadminTokenKey($accessToken), $expireTime, serialize($adminObjectArray));

        return ['accessToken' => $accessToken, 'expireTime' => $expireTime];
    }

    private function loginSession($data){
        $adminObjectArray = User::instance()->findIdentity($data['uid']);
        \Yii::$app->session->open();
        \Yii::$app->session->set('session',
            serialize($adminObjectArray));
        return true;
    }
}