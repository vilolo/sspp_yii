<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 2020/9/13
 * Time: 16:19
 */

namespace backend\modules\v1\controllers\basic;


use backend\modules\v1\controllers\base\BackendBaseController;
use common\models\GoodsOrder;
use common\utils\ExcelUtil;
use common\utils\JsonUtil;
use Yii;
use yii\web\Response;

class CgController extends BackendBaseController
{
    public function actionAddOrder(){
        $model = new GoodsOrder();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return JsonUtil::success('ok');
        }
        return JsonUtil::error(print_r($model->errors, true));
    }

    public function actionList(){
        Yii::$app->response->format = Response::FORMAT_HTML;
        $this->layout = false;
        $list = GoodsOrder::instance()->findAll(['status' => 2]);
        return $this->render('@app/views/cg/index', ['list'=>$list]);
    }

    public function actionExport(){
        return (new ExcelUtil())->exportExcel("商品列表", [['id' => 'waa', 'name' => 'asfasf']], [
            'id' => '商品ID',
            'name' => '商品名称'
        ]);
    }
}