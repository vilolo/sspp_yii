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
        foreach ($list as $k => $v){
            switch ($v['goods_type']){
                case '1':
                    $list[$k]['goods_type'] = $v['goods_type'].'(云南)';
                    break;
                case '2':
                    $list[$k]['goods_type'] = $v['goods_type'].'(通用16G)';
                    break;
                case '3':
                    $list[$k]['goods_type'] = $v['goods_type'].'(通用32G)';
                    break;
                case '4':
                    $list[$k]['goods_type'] = $v['goods_type'].'(通用64G)';
                    break;
                default:
                    $list[$k]['goods_type'] = $v['goods_type'].'(未知类型)';
                    break;
            }

            $list[$k]['created_at'] = date('Y-m-d H:i:s', $v['created_at']);
        }
        return $this->render('@app/views/cg/index', ['list'=>$list]);
    }

    public function actionExport(){
        Yii::$app->response->format = Response::FORMAT_HTML;
        $this->layout = false;
        $list = GoodsOrder::instance()->findAll(['status' => 2]);
        foreach ($list as $k => $v){
            switch ($v['goods_type']){
                case '1':
                    $list[$k]['goods_type'] = $v['goods_type'].'(云南)';
                    break;
                case '2':
                    $list[$k]['goods_type'] = $v['goods_type'].'(通用16G)';
                    break;
                case '3':
                    $list[$k]['goods_type'] = $v['goods_type'].'(通用32G)';
                    break;
                case '4':
                    $list[$k]['goods_type'] = $v['goods_type'].'(通用64G)';
                    break;
                default:
                    $list[$k]['goods_type'] = $v['goods_type'].'(未知类型)';
                    break;
            }

            $list[$k]['created_at'] = date('Y-m-d H:i:s', $v['created_at']);
        }

        return (new ExcelUtil())->exportExcel("商品列表", $list, [
            'id' => '订单id',
            'goods_type' => '商品类型',
            'price' => '价格',
            'account' => '数量',
            'name' => '下单名称',
            'mobile' => '联系电话',
            'address' => '地址',
            'remark' => '留言',
            'created_at' => '下单时间',
            'ip' => 'IP',
        ]);
    }

    public function actionDel(){
        $id = Yii::$app->request->getBodyParam('id');
        if (!$id){
            return JsonUtil::error('参数错误');
        }

        $order = GoodsOrder::findOne(['id' => $id]);
        $order->status = 0;
        if ($order->save()){
            return JsonUtil::success('ok');
        }else{
            return JsonUtil::error(print_r($order->errors, true));
        }
    }
}