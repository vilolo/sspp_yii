<?php


namespace backend\modules\v1\controllers\base;


use backend\modules\v1\behavior\BaseHttpBearerAuth;
use yii\helpers\ArrayHelper;

class BackendBaseLoginController extends BackendBaseController
{
    public function behaviors()
    {
        if (\Yii::$app->request->isOptions) {
            //options跨域，不需要做验证
            return parent::behaviors();
        }
        $rulesArr = [
            'authenticator' => [ //验证token
                'class' => BaseHttpBearerAuth::class,
                'from'=>$this
            ],
        ];

        return ArrayHelper::merge(
            parent::behaviors(),$rulesArr
        );
    }
}