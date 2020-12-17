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
        \Yii::$app->request->post('');
        $data = [
            'url' => \Yii::$app->request->post('url'),
            'img' => \Yii::$app->request->post('img'),
            'name' => \Yii::$app->request->post('name'),
            'statistics' => \Yii::$app->request->post('statistics'),
            'platform' => \Yii::$app->request->post('platform'),
        ];
        $res = \Yii::$app->db2->createCommand()->insert('sign_log', $data)->execute();
        return $res;
    }

    public function actionShowLog()
    {
        
    }

    public function actionShowCollect()
    {
        
    }
}