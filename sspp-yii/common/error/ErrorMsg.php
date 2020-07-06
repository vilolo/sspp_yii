<?php

namespace common\error;


class ErrorMsg
{
    /**
     * 定义错误描述信息
     *
     * @var array
     */
    public static $errMsg = [
        ErrorCode::ERR_SERVER_ERROR => '服务器繁忙，请稍后再试',
        ErrorCode::ERR_PARAMS_ERROR => '参数错误',
        ErrorCode::ERR_DATABASE_ERROR => '数据库操作异常',
        ErrorCode::ERR_ACCESS_TOKEN_ERROR => '在其他设备登录，如果不能确认安全，请重新设置登录密码',
        ErrorCode::ERR_REQUEST_MANY_ERROR => '请求太频繁,请稍后在进行操作',
        ErrorCode::ERR_REQUEST_METHOD_ERROR => '请求方法不允许',
        ErrorCode::ERR_USER_NO_EXISTS => '用户不存在',
        ErrorCode::ERR_SIGN_ERROR => '非法请求',
        ErrorCode::ERR_VIEW_TEAM_MAKER_COUNT_ERROR => '暂无权限查看',
        ErrorCode::ERR_LIVE_STREAM_ID_UNIQUE => '直播流ID重复',
        ErrorCode::ERR_COUPON_NOT_IN_USER_TARGET => '您不能领取此券',
        ErrorCode::ERR_COUPON_NO_STOCK => '此优惠券已领完',
        ErrorCode::ERR_COUPON_NUM_LIMIT => '已达到领取上限',
        ErrorCode::ERR_PERMISSION_DENIED => '权限不足, 请联系管理员',
    ];


    /**
     * 获取错误描述信息
     * @param $errCode
     * @return string
     */
    public static function getErrMsg($errCode)
    {
        return isset(self::$errMsg[$errCode]) ? self::$errMsg[$errCode] : self::getDefaultMsg();
    }

    /**
     * 获取默认的错误描述信息
     * @return string
     */
    public static function getDefaultMsg()
    {
        return '服务器繁忙，请稍后再试';
    }

}
