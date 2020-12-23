<?php


namespace backend\modules\v1\controllers\basic;


use backend\modules\v1\controllers\base\BackendBaseController;

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
        ];
        $res = \Yii::$app->db->createCommand()->insert('sign_log', $data)->execute();
        return $res;
    }

    public function actionShowLog()
    {
        $res = \Yii::$app->getDb()->createCommand()
        return $res;
    }

    public function actionShowCollect()
    {
        
    }
}