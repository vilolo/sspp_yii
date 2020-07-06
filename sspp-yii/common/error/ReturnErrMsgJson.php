<?php

namespace common\error;


trait ReturnErrMsgJson {
    public function json($data, $sucess = true){
        if(isset($data["retCode"])){
            $code = $data["retCode"];
            if($code!=ErrorCode::SUCCESS && !isset($data["errMsg"])){
                if (isset(ErrorMsg::$errMsg[$code])) {
                    $data["errMsg"] = ErrorMsg::$errMsg[$code];
                } else {
                    $data["errMsg"] = ErrorMsg::getDefaultMsg();
                }
            }
        }
        return parent::json($data,$sucess);
    }
}