<?php


namespace backend\modules\v1\controllers\basic;


use backend\modules\v1\controllers\base\BackendBaseController;
use common\utils\JsonUtil;

class GoodsController extends BackendBaseController
{//http://demo.local/index.php/v1/basic/goods/collect

    public function actionBatchSave()
    {
        
    }

    public function actionCollect()
    {
        $data = [
            'url' => \Yii::$app->request->post('url'),
            'img' => \Yii::$app->request->post('img'),
            'name' => \Yii::$app->request->post('name'),
            'statistics' => \Yii::$app->request->post('statistics'),
            'platform' => \Yii::$app->request->post('platform'),
            'json_item' => \Yii::$app->request->post('json_item'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        if (\Yii::$app->db->createCommand()->insert('sign_log', $data)->execute()){
            return JsonUtil::success();
        }else{
            return JsonUtil::error('收藏失败');
        }
    }

    public function actionShowLog()
    {
//        $res = \Yii::$app->db->createCommand()
//        return $res;
    }

    public function actionShowCollect()
    {
        
    }
}