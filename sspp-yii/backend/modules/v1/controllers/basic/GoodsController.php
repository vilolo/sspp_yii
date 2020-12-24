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
        $sql = 'select id, json_item from sign_log where status = 1 order by id desc';
        $res = \Yii::$app->db->createCommand($sql)->queryAll();
        $data = [];
        foreach ($res as $v){
            $temp = json_decode($v['json_item'], JSON_UNESCAPED_UNICODE);
            $temp['id'] = $v['id'];
            $data[] = $temp;
        }
        return JsonUtil::success(['goodsList' => $data]);
    }

    public function actionCollectDel()
    {
        $id = \Yii::$app->request->post('id');
        \Yii::$app->db->createCommand()->update('sign_log', ['status' => 0],"id=:id", [':id' => $id])
            ->execute();
        return JsonUtil::success();
    }
}