<?php

namespace backend\modules\v1\controllers\base;

use yii\base\InvalidConfigException;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;

class BackendBaseController extends YiiPerformanceRecordController
{
    public $identity;

    const LOGIN_TYPE_REDIS = 1;
    const LOGIN_TYPE_SESSION = 2;

    const LOGIN_TYPE = self::LOGIN_TYPE_SESSION;

    public function init()
    {
        try {
            parent::init();
        }
        catch (InvalidConfigException $e) {
            //yii规定resetful的controller必须设置$modelClass，处理忽略它
        }
        $this->enableCsrfValidation = false;
    }

    public function behaviors()
    {
        $rulesArr = [
            'corsFilter' => [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => false,
                    'Access-Control-Max-Age' => 86400,
                ],
            ],
        ];

        return ArrayHelper::merge(
            parent::behaviors(), $rulesArr
        );
    }
}