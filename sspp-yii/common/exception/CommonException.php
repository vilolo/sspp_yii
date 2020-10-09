<?php


namespace common\exception;


use common\constants\ResCode;
use common\utils\JsonUtil;
use RuntimeException;

class CommonException extends RuntimeException
{
    protected $response;

    public function __construct($msg = '',$code=500 , $status = 200, $data = [])
    {
        parent::__construct();
        return JsonUtil::error($msg, $code, $status, $data);
    }

    public function getData()
    {
        return $this -> response -> getData();
    }

    public function getResponse()
    {
        return $this->response;
    }
}