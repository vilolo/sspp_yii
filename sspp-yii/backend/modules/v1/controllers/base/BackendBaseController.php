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

    public function curlPost($url, $postData = false, $header = false) {
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //返回数据不直接输出
        curl_setopt($ch, CURLOPT_ENCODING, "gzip"); //指定gzip压缩
        //add header
        if(!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        //add ssl support
        if(substr($url, 0, 5) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //SSL 报错时使用
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    //SSL 报错时使用
        }
        //add 302 support
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch,CURLOPT_COOKIEFILE, $this->lastCookieFile); //使用提交后得到的cookie数据
        //add post data support
        if(!empty($postData)) {
            curl_setopt($ch,CURLOPT_POST, 1);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $postData);
        }

        $content = curl_exec($ch); //执行并存储结果
//        $curlError = curl_error($ch);
        curl_close($ch);
        return $content;
    }

    public function curlGet($url, $header = false) {
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //返回数据不直接输出
        curl_setopt($ch, CURLOPT_ENCODING, "gzip"); //指定gzip压缩
        //add header
        if(!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        //add ssl support
        if(substr($url, 0, 5) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //SSL 报错时使用
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    //SSL 报错时使用
        }
        //add 302 support
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $content = curl_exec($ch); //执行并存储结果
//        $curlError = curl_error($ch);
        curl_close($ch);
        return $content;
    }
}