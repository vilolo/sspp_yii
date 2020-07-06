<?php

namespace backend\modules\v1\controllers\base;

use api\modules\v1\controllers\YiiPerformanceRecordController;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;

class BackendBaseController extends YiiPerformanceRecordController
{
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

        ArrayHelper::merge(
            parent::behaviors(), $rulesArr
        );
    }
}