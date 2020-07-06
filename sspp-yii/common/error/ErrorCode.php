<?php

namespace common\error;

class ErrorCode
{

    const ERROR = 'error'; //全局错误标志

    /**
     * 错误码由7位数字组成，以正数字符串表示，前三位错误码标识模块（可理解为service，比如boss后台模块100等），
     * 模块部分从100开始，到999，紧接着的两位错误码标识模块下的动作，从01开始，到99，最后
     * 两位错误码标识具体的错误，从01开始，到99，所有错误码定义为常量，以ERR_做前缀 _ERROR做后缀
     * boss后台模块：-100xxxx
     */
    const SUCCESS = 200;    //200表示成功

    //系统级错误：-101xxxx
    const ERR_SERVER_ERROR = 1010000;//系统错误
    const ERR_PARAMS_ERROR = 1010001;  //参数错误
    const ERR_DATABASE_ERROR = 1010002; // 数据库操作错误
    const ERR_ACCESS_TOKEN_ERROR = 1010003; //token失效,请重新登录
    const ERR_REQUEST_MANY_ERROR = 1010004;//请求太频繁,请稍后在进行操作
    const ERR_REQUEST_METHOD_ERROR = 1010005;//请求方法不允许
    const ERR_USER_NO_EXISTS = 1010006;//用户不存在
    const ERR_WISH_NOT_ENOUGH = 1010007;//您的剩余心愿次数不够，请前往代金券专区免费领取心愿
    const ERR_SIGN_ERROR = 1010008;//非法请求,签名错误
    const ERR_REAL_NAME_AUTH_LIMIT = 1010009;//实名认证次数限制
    const ERR_JOIN_WISH_NOT_REAL_NAME = 1010010;// 参与心愿未实名认证
    const ERR_ID_CARD_AUDIT_LIMIT = 1010011;// 身份证实名认证人次限制
    const ERR_VIEW_TEAM_MAKER_COUNT_ERROR = 1010012;//没有权限查询团队下的播商数
    const ERR_PERMISSION_DENIED = 1010013;//没有权限(管理后台权限限制)

    const ERR_POLL_RESULT = 1010013; // 轮询结果为空

    //新人注册领取红包 不可再领取
    const ERR_REGISTER_RED_PACKET_ALREADY = 1010014; // 已经领取过新人红包
    const ERR_REGISTER_RED_PACKET_NEW_USER = 1010015; // 这是新用户专属红包
    const ERR_RED_PACKET_BLACK_USER = 1010016; // 邀请人已经加入黑名单
    const ERR_WX_MINI_PRO_AUTH = 1010017; // 小程序认证错

    /* 直播 */
    const ERR_LIVE_STREAM_ID_UNIQUE = 1101001; // 直播流重复

    /* 优惠券 */
    const ERR_COUPON_NOT_IN_USER_TARGET = 1201001; // 因用户不属于目标用户群组, 领取失败
    const ERR_COUPON_NO_STOCK = 1201002; // 已领完
    const ERR_COUPON_NUM_LIMIT = 1201003; // 已达到领取数量上限

    /* 春节活动分享 */
    const ERR_SHARE_ACTIVITY_NOT_FINISH = 1301001; // 上一轮分享助力还未完成，完成后才可开启新一轮
    const ERR_SHARE_ACTIVITY_NOT_NEW_USER = 1301002; // 不是分享助力来源的新用户

    /* 判断地址是否正确 */
    const ORDER_SHIPPING_ERR_COMPLETE = 1400001; // 订单地址填写错误 需要修改
    const USER_REGION_ERR_COMPLETE = 1400002; // 用户注册地址填需要完整 需要修改

    /* 合伙人申请 */
    const ERR_PARTNER_APPLY_UPGRADE_STRIDE = 1500001; // 不能跨级或降级
    const ERR_PARTNER_APPLY_NOT_SATISFY = 1500002; // 套餐数量不够
    const ERR_PARTNER_APPLY_IS_OCCUPY = 1500003; // 套餐数量不够

    /* 提现 */
    const ERR_WITHDRAW_UP_LOAD = 1600001; // 请上传清晰照片！
    const ERR_WITHDRAW_NOT_SAME_ID = 1600002; // 证件不一致！

    /* pv */
    const ERR_PV_NUM_NOT_ENOUGH = 1700001; // PV数量不够！

    /* 课程购买 */
    const ERR_COURSE_HAD_BUY = 1800001; // 课程已购买！

    /* 直播间红包相关 */
    const ERR_LIVE_RED_PACKET_UN_AT = 1900001; // 来早了，还没开始呢！
    const ERR_LIVE_RED_PACKET_USER_TYPE = 1900002; // 没有达到对应等级，不符合抢红包的条件哦~
    const ERR_LIVE_RED_PACKET_SHARE = 1900003; // 只有分享了直播间才能抢红包哦
    const ERR_LIVE_RED_PACKET_SLOW = 1900004; // 手慢了，红包派完了
    const ERR_LIVE_RED_PACKET_GRAD_LIMIT = 1900005; // 手不要贪心嘛，已经抢了一个

}
