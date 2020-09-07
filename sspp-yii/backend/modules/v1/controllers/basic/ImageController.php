<?php


namespace backend\modules\v1\controllers\basic;


use backend\modules\v1\controllers\base\BackendBaseController;
use common\utils\JsonUtil;
use Yii;

class ImageController extends BackendBaseController
{
    public function actionIndex(){
        $dirName = Yii::$app->request->get('dir');
        $path="/uploads/备忘图片文件夹/{$dirName}/";
        $res = $this->listFile($path, $dirName, $dirName == 'public');
        return JsonUtil::success($res);
    }

    private function listFile($path, $dirName, $isChildDir = false){
        $fullPath = Yii::$app->basePath.'/web'.$path;
        @$rootFiles = scandir($fullPath);
        $list = [];
        if ($rootFiles){
            foreach ($rootFiles as $v){
                if ($v == '不显示') continue;
                if(is_dir($fullPath.$v)){
                    if (!$isChildDir) continue;
                    if($v=='.' || $v=='..') continue;
                    $childDir=scandir($fullPath.$v);
                    foreach ($childDir as $l2){
                        if($l2=='.' || $l2=='..') continue;
                        $list[$v][] = Yii::$app->request->hostInfo.$path.$v.'/'.$l2;
                    }
                }else{
                    $list[$dirName][] = Yii::$app->request->hostInfo.$path.$v;
                }
            }
        }
        return $list;
    }

    private function listFile_old($dir, $dirName){
        $imgList = [];
        $dirList = [];
        $path = Yii::$app->basePath.'/web'.$dir;
        $topDir=scandir($path);
        foreach($topDir as $v){
            if ($v == '不显示') continue;
            if(is_dir($path.$v)){//如果是文件夹则执行
                if ($dirName != 'public') continue;
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

        if ($dirName == 'public'){
            $dirList['根目录图片'] = $imgList;
            return $dirList;
        }else{
            return $imgList;
        }
    }
}