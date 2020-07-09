<?php
namespace common\utils;
/**
 * Created by PhpStorm.
 * User: seven
 * Date: 2019/3/11
 * Time: 下午10:13
 */

use Yii;
use yii\web\Response;

class JsonUtil extends BaseUtil
{
    /**
     * 成功返回
     * @param array $data
     * @param int $code
     * @param int $status
     * @return array
     */
    public static function success($data = [],$code=200,$status = 200){
        $returnData = [
            'code'=>$code, //业务码
            'message'=>'ok',//提示信息
            'data'=>$data, //业务数据
            'status'=>$status//http状态码
        ];

        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->setStatusCode($status);
        Yii::$app->response->data =  $returnData;
//        if(YII_ENV != 'dev'){
//            Yii::$app->response->data =  \Yii::$app->rsa->privateEncrypt(json_encode($returnData));
//        }else{
//            Yii::$app->response->data =  $returnData;
//        }

        return Yii::$app->response->data;
    }

    /**
     * 错误返回
     * @param string message
     * @param int $code
     * @param int $status
     * @return array
     */
    public static function error($msg = '',$code=500 , $status = 200, $data = []){
        $returnData = [
            'code'=>$code, //业务码
            'message'=>$msg, //提示信息
            'data'=> $data, //业务数据
            'status'=>$status//http状态码
        ];
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->setStatusCode($status);
        Yii::$app->response->data =  $returnData;
        return Yii::$app->response->data;
    }
}