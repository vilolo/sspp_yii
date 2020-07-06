<?php

namespace common\error;

trait ReturnErrorTrait
{

    /**
     * @param string $errCode
     * @param string $logMessage
     * @param string $errMessage
     * @return string
     */
    public static function setAndReturn($errCode = "", $logMessage = '', $errMessage = '')
    {

        ErrorInfo::setAndReturn($errCode, $logMessage, $errMessage);
        return ErrorCode::ERROR;
    }

    public function getErrCode()
    {
        $errCode = ErrorInfo::getErrCode();
        if ($errCode == '') {
            $errCode = ErrorCode::SUCCESS;
        }

        return $errCode;
    }

    public function getErrMsg()
    {
        return ErrorInfo::getErrMsg();
    }

    public function getLogMsg()
    {
        return ErrorInfo::getLogMsg();
    }

    public function getAllFirstErrorMessage()
    {
        if (empty($this->firstErrors)) {
            return '';
        }
        return implode(';', $this->firstErrors);
    }
}
