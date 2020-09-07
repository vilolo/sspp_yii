<?php


namespace backend\modules\v1\controllers\basic;


use backend\modules\v1\controllers\base\BackendBaseController;
use common\utils\JsonUtil;
use Yii;

class ImageController extends BackendBaseController
{
    public function actionIndex(){
        $path="/uploads/备忘图片文件夹/";
        $res = $this->listFile($path);
        return JsonUtil::success($res);
    }

    private function listFile($dir){
        $imgList = [];
        $dirList = [];
        $path = Yii::$app->basePath.'/web'.$dir;
        $topDir=scandir($path);
        foreach($topDir as $v){
            if ($v == '不显示') continue;
            if(is_dir($path.$v)){//如果是文件夹则执行
                if($v=='.' || $v=='..'){//判断是否为系统隐藏的文件.和..  如果是则跳过否则就继续往下走，防止无限循环再这里。
                    continue;
                }
                $childDir=scandir($path.$v);
                foreach ($childDir as $l2){
                    if($l2=='.' || $l2=='..'){//判断是否为系统隐藏的文件.和..  如果是则跳过否则就继续往下走，防止无限循环再这里。
                        continue;
                    }
                    $dirList[$v][] = Yii::$app->request->hostInfo.$dir.$v.'/'.$l2;
                }
            }else{
                $imgList[] = Yii::$app->request->hostInfo.$dir.$v;
            }
        }
        $dirList['根目录图片'] = $imgList;
        return $dirList;
    }
}