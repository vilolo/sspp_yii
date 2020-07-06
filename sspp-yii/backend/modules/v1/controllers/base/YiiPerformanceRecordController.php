<?php

namespace api\modules\v1\controllers;

use yii\base\Application;
use yii\rest\ActiveController;


class YiiPerformanceRecordController extends ActiveController {

    private $timeRecord;
    private $actionName;

    public function __construct($id,$module,$config = []){
        parent::__construct($id,$module,$config);
        global $timeRecord;
        $this->timeRecord = & $timeRecord;
    }

    public function beforeAction($action){
        $this->actionName = $action->getUniqueId();
        $this->timeRecord[] = "before before action\t:".microtime();
        $result = parent::beforeAction($action);
        $this->timeRecord[] = "after before action\t:".microtime();
        return $result;
    }

    public function afterAction($action,$result){
        $this->timeRecord[] = "before after action\t:".microtime();
        $result = parent::afterAction($action,$result);
        $this->timeRecord[] = "after after action\t:".microtime();
        \Yii::$app->on(Application::EVENT_AFTER_REQUEST,array($this,"appEnd"));
        return $result;
    }

    public function appEnd(){
        $this->timeRecord[] = "end appRun\t\t:".microtime();
        register_shutdown_function(array($this,"onShutdown"));
    }

    public function onShutdown(){
        $this->timeRecord[] = "php shutdown\t\t:".microtime();
        $timeRec = "\r\naction name:".$this->actionName."\r\n".
            implode("\r\n",$this->timeRecord)."\r\n";
        \Yii::info($timeRec,"performance");
    }
}