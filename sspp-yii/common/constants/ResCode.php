<?php


namespace common\constants;


class ResCode
{
    const SUCCESS = 200;
    const API_NOT_FOUND = 404;

    public static function getMessageByCode($code)
    {
        return [
            self::API_NOT_FOUND => '页面未找到'

            ][$code]??'';
    }
}