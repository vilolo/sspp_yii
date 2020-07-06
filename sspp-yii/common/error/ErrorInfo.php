<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\error;

class ErrorInfo
{
    private static $errCode = '';
    private static $errMsg = '';
    private static $logMsg = '';

    public static function getErrCode()
    {
        return self::$errCode;
    }

    public static function getErrMsg()
    {
        return self::$errMsg;
    }

    public static function getLogMsg()
    {
        return self::$logMsg;
    }

    /**
     * 设置返回内容
     * @param unknown $errCode 错误码
     * @param string $logMsg 日志信息内容
     * @param string $msg  自定义错误信息
     * @return boolean
     */
    public static function setAndReturn($errCode, $logMsg = '',$msg='')
    {

        self::$errCode = $errCode;
        self::$logMsg = 'errorCode:'.$errCode.','.$logMsg;

        //记录日志来源
        $debugBacktrace = isset(debug_backtrace()[1]) ? debug_backtrace()[1] : '';
        if(!empty($debugBacktrace)){
            $fileName = $debugBacktrace['file'];
            $line = $debugBacktrace['line'];
            self::$logMsg = 'filename:'.$fileName.',line:'.$line.','.self::$logMsg;
        }

        $maxLogLen = 1000000;
        if(mb_strlen(self::$logMsg) > $maxLogLen){
            self::$logMsg  = mb_substr(self::$logMsg,0,$maxLogLen,'utf-8');
        }

        if (isset(ErrorMsg::$errMsg[$errCode])) {
        	if (empty($msg)) {
        		self::$errMsg = ErrorMsg::$errMsg[$errCode];
        	}else{
        		self::$errMsg = $msg;
        	}

        } else {
            if(empty($msg)){
                self::$errMsg = ErrorMsg::getDefaultMsg();
            }else{
                self::$errMsg = $msg;
            }
        }
        return false;
    }
}
