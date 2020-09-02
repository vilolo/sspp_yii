<?php

namespace common\constants;

/**
 * Created by PhpStorm.
 * User: seven
 * Date: 2019/3/19
 * Time: 上午9:40.
 */
class CacheKey
{
    //string
    const STRING_SMSCODE = 'string:smscode:';//发送验证码key
    const STRING_SMSCODE_TICKET = 'string:smscode:ticket';//发送验证码key
    const STRING_SMSCODE_LIVE_ADMIN = 'string:smscode:live_admin';//直播管理员发送验证码key
    const STRING_USER_TOKEN = 'string:user_token:'; //获取App用户登录token的key
    const STRING_USER_H5_TOKEN = 'string:h5:user_token:'; //获取H5用户登录token的key
    const STRING_USER_MINI_PRO_TOKEN = 'string:mini_pro:user_token:'; //获取微信用户登录token的key
    const STRING_ADMIN_TOKEN = 'string:admin_token:'; //获取admin登录token的key
    const STRING_SUPPLIER_TOKEN = 'string:supplier_token:'; //获取admin登录token的key
    const STRING_LIVE_ADMIN_TOKEN = 'string:live_admin_token:'; //获取liveAdmin登录token的key
    const STRING_USER_INFO = 'string:user_info:'; //获取用户信息的key
    const STRING_VIDEO_INFO = 'string:video_info:'; //获取小视频的key
    const STRING_GOODS_INFO = 'string:goods_info:'; //获取商品的key


    const STRING_GOODS_LIST = 'string:goods_list:'; //获取商品的key
    const STRING_GOODS_CAT = 'string:goods_cat:'; //获取商品分类的key
    const STRING_BLOCK_CHAIN_CONTRACT_ADDRESS = "string:block_chain_contract_address"; // 区块链合约账号的Key
    const STRING_BLOCK_CHAIN_ACCOUNT_NONCE = "string:block_chain_contract_nonce:"; // 区块链合约账号的Key
    const STRING_ADS_APP_SHOW = 'string:ads_app_show';//广告app展示页
    const STRING_SET_WE_CHAT_USER = "string:we_chat_user:"; // 微信用户
    const STRING_SET_WE_CHAT_OPENID = "string:we_chat_openid:"; // 微信用户的OpenId
    const STRING_SET_WE_CHAT_MINI_PRO_AUTH = "string:we_chat_mini_pro_auth:"; // 微信小程序认证
    const STRING_REGION_INFO = "string:region_info:";//单个地区缓存信息
    const STRING_VERIFY_MOBILE = 'string:verify_mobile:';//注册时候已经验证过的手机号
    const STRING_IP_BLACK_INFO_KEY = 'string:ip_black_info:';//ip黑名单
    const STRING_CHILDREN_TEAM_COUNT = 'string:children_team_count:';//缓存团队数量
    const STRING_LOOK_SECOND = 'string:look_second';//划过
    const STRING_LOOK_FIVE = 'string:look_five';//看过5秒
    const STRING_LOOK_FIFTEEN = 'string:look_fifteen';//看过15秒
    const STRING_LOOK_OVER = 'string:look_over';//看完
    const STRING_LOOK_VIDEO_CONFIG = 'string:look_video_config';//看完
    const STRING_TOTAL_PROFIT = "string:total_profit:";//礼娱赚的总收益
    const STRING_NEW_USER_GOODS = "string:new_user_goods:";//新人专区商品
    const STRING_ZERO_PURCHASE_GOODS = "string:zero_purchase_goods:";//0元购商品
    const STRING_GIFT_PACKAGE_GOODS = "string:gift_package_goods:";//礼包商品
    const STRING_WISH_GOODS = "string:wish_goods:";//礼券商品
    const STRING_SEC_KILL_GOODS = "string:sec_kill_goods:";//秒杀商品
    const STRING_PLATFORM_GOLDFISH_TOTAL = "string:platform_goldfish_total:";// 平台总收益
    const STRING_AD = "string:ad:"; // 广告位置
    const STRING_USER_WINE = "string:user:wine:"; // 用户领酒
    const STRING_MOBILE_BLACK = 'string:mobile_black:'; //手机号码黑名单
    const STRING_TOP_RED_PACKET_PROFIT = 'string:top_red_packet_profit:'; //手机号码黑名单
    const STRING_LIVE_BREAK_STREAM = 'string:live_break_stream:'; //直播断流
    const STRING_LIVE_PRIVATE_CODE = 'string:live_private_code:'; //私域直播验证MD5key

    const STRING_LOCK = "string:lock:"; // 锁的KEY
    const STRING_PAYMENT_LOCK = "string:lock:payment:"; // 锁的KEY
    const STRING_CLOCK_LOCK = "string:lock:clock:"; // 打卡锁的KEY
    const STRING_WITHDRAW_APPLY_LOCK = "string:lock:withdraw_apply:"; // 申请提现锁的KEY

    const STRING_BANNER_HOME_RECOMMEND = "string:banner:home_recommend:"; // 栏目首页推荐Banner
    const STRING_GOODS_HOME_RECOMMEND = "string:goods:home_recommend:"; // 栏目首页推荐商品

    const STRING_LIVE_GOODS_SALES = 'string:live_goods_sales:'; //统计直播的销量
    const STRING_LIVE_UNIQUE_VISITOR_ZAN = 'string:live:unique_visitor_id:'; //统计直播的销量
    const STRING_LIVE_UNIQUE_VISITOR_ZAN_CLOSE_VALUE = 'string:live:close_value_unique_visitor_id:'; //统计直播的销量
    const STRING_LIVE_REAL_DATA = 'string:live:real_data:'; // 获取真实的live数据


    //hash
    const HASH_SET_BLOCK_CHAIN_MAIN_ACCOUNT = "hs:block_chain_main_account"; // 区块链主账号的Key
    const HASH_SET_BLOCK_CHAIN_CONTRACT_ACCOUNT = "hs:block_chain_contract_account"; // 区块链合约账号的Key
    const HASH_SET_CONFIG = "hs:config"; // 配置
    const HASH_SET_ACTIVITY_CONFIG = "hs:activity_config"; // 配置
    const HASH_SET_VIDEO_LOOK_NUM_SET = "hs:video_look_num_set"; // 配置
    const HASH_SET_GOODS_STOCK_INFO = "hs:goods:stock:"; // 商品库存信息
    const HASH_SET_STATISTIC_GOODS_VIEWS_WEEK = "hs:statistic:goods_views_week:"; // 统计 - 商品按周浏览量
    const HASH_SET_STATISTIC_GOODS_VIEWS_WEEK_UNIQUE = "hs:statistic:goods_views_week_unique:"; // 统计 - 商品按周浏览量, 按用户记唯一

    const HASH_SET_EFFECT_CONFIG = "hs:effect_config"; // 失效配置

    const STRING_LIVE_RED_PACKET = "string:live_red_packet:";
    const INCR_LIVE_RED_PACKET = "incr:live_red_packet:";
    const HASH_GRAD_RED_PACKET = "hs:grad_red_packet:";

    //list
    const STRING_GRAD_LIVE_RED_PACKET = "string:grad_live_red_packet:";
    const LIST_GRAD_LIVE_RED_PACKET = "list:grad_live_red_packet:";
    const HASH_GRAD_LIVE_RED_PACKET_RESULT = "hash:grad_live_red_packet_result:";
    const LIST_LIMIT_RATE = 'list:limit_rate:'; //请求接口速率限制
    const LIST_LOG_QUEUE = 'list:log_queue'; //系统错误日志队列
    const LIST_GOODS_NOPAY_QUEUE = 'list:goods_nopay_queue'; //记录用户下单成功的土豪包id与过期时间，过期时间未支付就取消土豪包

    const LIST_LOTTERY = "list:lottery"; // 抽奖队列
    const LIST_LOTTERY_ROUND = "list:lottery_round"; // 待处理礼券轮
    const LIST_LOTTERY_ROUND_SUCCESS = "list:lottery_round_success"; // 处理成功的礼券轮
    const LIST_LOTTERY_WISH = "list:lottery_wish"; // 待处理礼券
    const LIST_LOTTERY_WISH_SUCCESS = "list:lottery_wish_success"; // 处理成功的礼券

    const LIST_VIRTUAL_USE_RAND = "list:virtual_user_rand:"; // 随机用户列表
    const LIST_INVITERS = "list:inviters:"; // 推荐人编号列表

    const LIST_EXECPTION_ACCOUNT = 'list:execption_account:'; //异常账号队列

    const LIST_VIDEO_LOOK_TIME = 'list:video_look_time:'; //观看视屏时间数据队列
    const LIST_VIDEO_STATEMENT_SORT = 'list:video_statement_sort:'; //视屏排序数据队列

    const LIST_PUSH_NOTIFICATION = "list:push:notification"; // Push 通知队列
    const LIST_PUSH_MESSAGE = "list:push:message"; // Push 消息队列
    const LIST_SYS_MESSAGE_CACHE = "list:sys_message_cache"; // 系统消息放到队列

    const LIST_END_LIVE_VOD = "list:end_live_vod"; //结束直播恢复队列
    const LIST_VOD_TASK = "list:vod_task";        //生成回放任务


    const LIST_MAKER_ORDER = "list:maker:order"; // 金牌经纪人订单队列
    const HASH_SET_MAKER_ORDER_RESULT = "hs:maker:order:result"; // 金牌经纪人订单结果队列

    const LIST_PAID_CLOCK_APPLY_ORDER = "list:paid_clock_apply:order"; // 有偿打卡报名订单队列
    const HASH_SET_PAID_CLOCK_APPLY_RESULT = "hs:paid_clock_apply:order:result"; // 有偿打卡报名订单结果队列

    const LIST_NORMAL_ORDER = "list:normal:order"; // 订单队列
    const HASH_SET_NORMAL_ORDER_RESULT = "hs:normal:order:result"; // 订单结果队列

    const LIST_SEC_KILL_ORDER = "list:sec_kill:order"; // 订单队列
    const HASH_SET_SEC_KILL_RESULT = "hs:sec_kill:order:result"; // 订单结果队列

    const LIST_GET_WINE = "hs:get:wine"; // 获取酒仙优惠券
    const HASH_SET_GET_WINE_RESULT = "hs:get:wine:result"; // 获取酒仙优惠券

    //incr
    const INCR_SEND_MESSAGE_IP = 'incr:send_message_ip:';//每天发送短信验证码每个ip限制
    const INCR_ORDER_NO_DAY = 'order_no:incr:'; //订单自增

    // SET
    const SET_RECOMMEND_MAKER_LIST = "set:recommend_maker_list";
    const SET_NEAR_RAND_USER = 'set:near_rand_user'; // 缓存附近的随机用户
    const SET_GUESS_LIKE_CATEGORY = "set:guess_like_category:"; // 猜你喜欢
    const SET_USER_LIST_OF_TAG = 'set:user_list_of_tag:'; // 拥有所属标签的用户列表
    const SET_RAND_USER_AVATAR = 'set:rand_user_avatar'; // 缓存随机用户头像
    const SET_SUPPLIER_ORDER_SUCCESS = 'set:supplier_order_success'; // 缓存订单完成


    // sorted set
    const SORTED_SET_HOT_VIDEO_RANK = "sorted-set:hot_video_rank"; // 热门视频排行榜
    const SORTED_SET_RED_USER_RANK = "sorted-set:red_user_rank"; // 红人排行榜
    const SORTED_SET_RED_ACTIVITY_RANK = "sorted-set:Activity_rank"; // 红人排行榜
    const SORTED_SET_PROFIT_TOP_GOODS = "sorted-set:profit_top_goods:"; // 利润TOP xxx 商品
    const SORTED_SET_GOLDFISH_RANK = "sorted-set:goldfish:"; // 收益榜

    const SORTED_SET_SYS_MESSAGE_TYPE = "sorted-set:sys_message:"; // 消息类型
    const SORTED_SET_SHOP_GOODS_CHANNEL = "sorted-set:shop-goods-channel"; // 商品分类


    const SORT_SET_BAD_WORD_INFO = 'sorted-set:bad_word_info'; //获取所有关键字的key
    const STRING_BAD_WORD_INFO = 'string:bad_word_info:'; //获取所有关键字的key

    const ORDER_LOCK_KEY = "order:";
    const ORDER_REFOUND_LOCK_KEY = "order_refound:";
    const GET_WINE_LOCK_KEY = "get_wine:";
    const SEND_COUPON_KEY = "send_coupon:";
    const GRAD_PROFIT_KEY = "grad_profit:";
    const GRAD_LIVE_KEY = "grad_live:";
    const GRAD_REGISTER_KEY = "grad_register:";
    const OPEN_PRIZE_KEY = "open_prize:";
    const GRAD_REGISTER_SPRING_KEY = "spring_activity:";
    const LOCK_LIVE_ADD_ZAN = "lock_live_add_zan:";
    const LOCK_FOLLOW_USER = "lock_follow_user:";
    const WISH_LOCK_KEY = "wish:";


    // mq
    const MQ_LIVE_TASK = 'mq_live_task';
    const MQ_VIDEO_VIRTUAL_DATA = 'mq_video_virtual_data';
    const MQ_COUPON_SEND = 'mq_coupon_send';

    // 秒杀
    const SEC_KILL_REMIND = "list:sec_kill:remind"; // 秒杀提醒
    const SEC_KILL_GOODS = "list:sec_kill:goods:"; // 秒杀提醒

    // 打赏
    const LIST_LIVE_REWARD = "list:live:reward"; // 打赏队列

    const HASH_ACTIVITY_REWARD = "hs:reward:"; // 打赏哈希

    const HASH_ZAN_CLOSE_VALUE_LIMIT = "hs:zan:close_value:"; // 赞亲密度哈希

    // 热度
    const LIST_LIVE_HEAT = "list:live:heat"; // old热度队列
    const LIST_LIVE_NEW_HEAT = "list:live:new_heat"; // new热度队列
    const HASH_LIVE_REDIS_HEAT = "hs:live:redis_heat"; // redis热度
    const LIST_LIVE_DB_HEAT = "list:live:db_heat"; // db热度队列
    const LIST_LIVE_HEAT_MSG = "list:live:heat_msg"; // 热度消息

    const LIST_FANS_CLOSE_VALUE = "list:fans:close_value"; // 亲密度
    const LIST_IM_CALL_BACK = "list:im:call_back"; // 消息回调

    //===============string start===========================//


    /**
     * 检查回放任务队列
     * @return string
     */
    public static function getListVodTask()
    {
        return self::LIST_VOD_TASK;
    }

    /**
     * 直播结束队列
     * @return string
     */
    public static function getEndLiveVodList()
    {
        return self::LIST_END_LIVE_VOD;
    }

    /**
     * 直播断流
     * @param $streamId
     * @return string
     */
    public static function getLiveBreakStream($streamId)
    {
        return self::STRING_LIVE_BREAK_STREAM . $streamId;
    }

    /**
     * 订单自增
     * @param string $date
     * @return string
     */
    public static function getIncrOrderNoDay($date = '')
    {

        if (empty($date)) {
            $date = date('Ymd');
        }

        return self::INCR_ORDER_NO_DAY . $date;
    }

    /**
     * 礼娱赚的总收益
     * @param $userId
     * @return string
     */
    public static function getStringTotalProfit($userId)
    {
        return self::STRING_TOTAL_PROFIT . $userId;
    }

    /**
     * 获取附近随机用户
     * @return string
     */
    public static function geSetNearRandUser()
    {
        return self::SET_NEAR_RAND_USER;
    }

    /**
     * 获取随机用户头像
     * @return string
     */
    public static function geRandUserAvatar()
    {
        return self::SET_RAND_USER_AVATAR;
    }

    /**
     * 团队数量缓存
     * @param $userId
     * @return string
     */
    public static function getStringChildrenTeamCount($userId)
    {
        return self::STRING_CHILDREN_TEAM_COUNT . $userId;
    }

    /**
     * ip黑名单
     * @param $ipAddr
     * @return string
     */
    public static function getIpBlackInfoKey($ipAddr)
    {
        return self::STRING_IP_BLACK_INFO_KEY . $ipAddr;
    }

    /**
     * 每天发送短信验证码每个ip限制
     * @param $ip
     * @return string
     */
    public static function getIncrSendMessageIp($ip)
    {
        return self::INCR_SEND_MESSAGE_IP . $ip;
    }

    /**
     * 获取App用户登录token key.
     *
     * @param $accessToken
     *
     * @return string
     */
    public static function getUserTokenKey($accessToken)
    {
        return self::STRING_USER_TOKEN . $accessToken;
    }

    /**
     * 获取H5用户登录token key.
     *
     * @param $accessToken
     *
     * @return string
     */
    public static function getH5UserTokenKey($accessToken)
    {
        return self::STRING_USER_H5_TOKEN . $accessToken;
    }

    /**
     * 获取小程序用户登录的token
     * @param $accessToken
     * @return string
     *
     */
    public static function getMiniProUserTokenKey($accessToken)
    {
        return self::STRING_USER_MINI_PRO_TOKEN . $accessToken;
    }

    /**
     * 获取admin登录token key.
     *
     * @param $accessToken
     *
     * @return string
     */
    public static function getAdminTokenKey($accessToken)
    {
        return self::STRING_ADMIN_TOKEN . $accessToken;
    }

    /**
     * 获取supplier登录token key.
     *
     * @param $accessToken
     *
     * @return string
     */
    public static function getSupplierTokenKey($accessToken)
    {
        return self::STRING_SUPPLIER_TOKEN . $accessToken;
    }

    /**
     * 获取liveAdmin登录token key.
     *
     * @param $accessToken
     *
     * @return string
     */
    public static function getLiveAdminTokenKey($accessToken)
    {
        return self::STRING_LIVE_ADMIN_TOKEN . $accessToken;
    }

    /**
     * 获取用户信息.
     *
     * @param $id
     *
     * @return string
     */
    public static function getUserInfoKey($id)
    {
        return self::STRING_USER_INFO . $id;
    }

    /**
     * 获取用户信息.
     *
     * @param $id
     *
     * @return string
     */
    public static function getLiveGoodsSales($id)
    {
        return self::STRING_LIVE_GOODS_SALES . $id;
    }


    /**
     * 获取小视频信息.
     *
     * @param $id
     *
     * @return string
     */
    public static function getVideoInfoKey($id)
    {
        return self::STRING_VIDEO_INFO . $id;
    }

    /**
     * 获取商品信息.
     *
     * @param $id
     *
     * @return string
     */
    public static function getGoodsInfoKey($id)
    {
        return self::STRING_GOODS_INFO . $id;
    }

    /**
     * 获取商品信息.
     *
     * @param $id
     *
     * @return string
     */
    public static function getBadWordInfoIdKey()
    {
        return self::SORT_SET_BAD_WORD_INFO;
    }

    /**
     * 获取商品信息.
     *
     * @param $id
     *
     * @return string
     */
    public static function getBadWordInfoInfoKey($id)
    {
        return self::STRING_BAD_WORD_INFO . "{$id}";
    }


    /**
     * 获取栏目首页推荐Banner
     * @param $id
     * @return string
     *
     */
    public static function getBannerHomeRecommend($id)
    {
        return self::STRING_BANNER_HOME_RECOMMEND . $id;
    }

    /**
     * 获取栏目首页推荐Banner
     * @param $id
     * @return string
     *
     */
    public static function getGoodsHomeRecommend($id)
    {
        return self::STRING_GOODS_HOME_RECOMMEND . $id;
    }

    /**
     * 获取新人专区的商品Key
     * @param $id
     * @return string
     *
     */
    public static function getNewUserGoods($id)
    {
        return self::STRING_NEW_USER_GOODS . $id;
    }

    /**
     * 获取0元购专区的商品Key
     * @param $id
     * @return string
     *
     */
    public static function getZeroPurchaseGoods($id)
    {
        return self::STRING_ZERO_PURCHASE_GOODS . $id;
    }

    /**
     * 获取礼包商品Key
     * @param $id
     * @return string
     *
     */
    public static function getGiftPackageGoods($id)
    {
        return self::STRING_GIFT_PACKAGE_GOODS . $id;
    }

    /**
     * 获取礼券专区的商品Key
     * @param $id
     * @return string
     *
     */
    public static function getWishGoods($id)
    {
        return self::STRING_WISH_GOODS . $id;
    }

    /**
     * 获取秒杀商品Key
     * @param $id
     * @return string
     *
     */
    public static function getSecKillGoods($id)
    {
        return self::STRING_SEC_KILL_GOODS . $id;
    }

    /**
     * 获取商品列表信息.
     *
     * @param $id
     *
     * @return string
     */
    public static function getGoodsListKey($str)
    {
        return self::STRING_GOODS_LIST . $str;
    }

    /**
     * 获取商品列表信息.
     *
     * @param $id
     *
     * @return string
     */
    public static function getGoodsCatKey($id)
    {
        return self::STRING_GOODS_CAT . $id;
    }

    /**
     * 验证码key
     * @param $mobile
     * @return string
     */
    public static function getSmscodeKey($mobile)
    {
        return self::STRING_SMSCODE . $mobile;
    }

    /**
     * 直播管理验证码key
     * @param $mobile
     * @return string
     */
    public static function getLiveAdminSmscodeKey($mobile)
    {
        return self::STRING_SMSCODE_LIVE_ADMIN . $mobile;
    }

    /**
     * 私域直播验证MD5key
     * @param $code
     * @return string
     */
    public static function getPrivateLiveCodeKey($code)
    {
        return self::STRING_LIVE_PRIVATE_CODE . $code;
    }

    /**
     * 验证码key
     * @param $mobile
     * @return string
     */
    public static function getSmscodeTicketKey($mobile)
    {
        return self::STRING_SMSCODE_TICKET . $mobile;
    }

    /**
     * 获取平台收益总额缓存Key
     * @return string
     *
     */
    public static function getPlatformGoldfishTotal()
    {
        return self::STRING_PLATFORM_GOLDFISH_TOTAL;
    }

    /**
     * 获取锁的Key
     * @param $lockKey
     * @return string
     */
    public static function getLockKey($lockKey)
    {
        return self::STRING_LOCK . $lockKey;
    }

    /**
     * 获取合约地址缓存Key
     * @return string
     */
    public static function getBlockChainContractAddress()
    {
        return self::STRING_BLOCK_CHAIN_CONTRACT_ADDRESS;
    }


    /**
     * 获取账户的Nonce缓存Key
     * @param $address
     * @return string
     */
    public static function getBlockChainAccountNonce($address)
    {
        return self::STRING_BLOCK_CHAIN_ACCOUNT_NONCE . $address;
    }


    /**
     * 启动页后广告缓存
     * @return string
     */
    public static function getAdsAppShow()
    {
        return self::STRING_ADS_APP_SHOW;
    }

    public static function getWeChatUserKey($unionId)
    {
        return self::STRING_SET_WE_CHAT_USER . $unionId;
    }

    public static function getWeChatOpenId($openId)
    {
        return self::STRING_SET_WE_CHAT_OPENID . $openId;
    }

    public static function getWeChatMinProAuth($key)
    {
        return self::STRING_SET_WE_CHAT_MINI_PRO_AUTH . $key;
    }


    /**
     * 单个地区缓存
     * @param $id
     * @return string
     */
    public static function getRegionKey($id)
    {
        return self::STRING_REGION_INFO . $id;
    }

    /**
     * 注册时已验证过的手机号
     * @param $mobile
     * @return string
     */
    public static function getVerifyMobile($mobile)
    {
        return self::STRING_VERIFY_MOBILE . $mobile;
    }

    /**
     * 获取广告位置相关图片
     * @param $type
     * @param $position
     * @return string
     *
     */
    public static function getAd($type, $position)
    {
        return self::STRING_AD . "{$type}:{$position}";
    }

    /**
     * 用户是否领券的Key
     * @param $userId
     * @return string
     *
     */
    public static function getUserWine($userId)
    {
        return self::STRING_GET_WINE . $userId;
    }

    //===============string end===========================//

    //===============list start===========================//

    /**
     * 请求接口速率限制.
     *
     * @param $ip
     *
     * @return string
     */
    public static function getLimitRateQueue($ip)
    {
        return self::LIST_LIMIT_RATE . $ip;
    }

    /**
     * log 错误日志队列.
     *
     * @return string
     */
    public static function getLogQueue()
    {
        return self::LIST_LOG_QUEUE;
    }

    /**
     * 记录用户下单成功的土豪包id与过期时间，过期时间未支付就取消土豪包.
     *
     * @return string
     */
    public static function getGoodsNopayQueue()
    {
        return self::LIST_GOODS_NOPAY_QUEUE;
    }


    //===============list end=========================//

    /**
     * 获取抽奖列表缓存Key
     * @return string
     */
    public static function getListLottery()
    {
        return self::LIST_LOTTERY;
    }

    /**
     * 获取待处理礼券轮缓存Key
     * @return string
     */
    public static function getListLotteryRound()
    {
        return self::LIST_LOTTERY_ROUND;
    }

    /**
     * 获取处理成功的礼券轮缓存Key
     * @return string
     */
    public static function getListLotteryRoundSuccess()
    {
        return self::LIST_LOTTERY_ROUND_SUCCESS;
    }

    /**
     * 获取待处理礼券缓存Key
     * @return string
     */
    public static function getListLotteryWish()
    {
        return self::LIST_LOTTERY_WISH;
    }

    /**
     * 获取处理成功的礼券缓存Key
     * @return string
     */
    public static function getListLotteryWishSuccess()
    {
        return self::LIST_LOTTERY_WISH_SUCCESS;
    }

    /**
     * 随机用户列表
     * @param $id
     * @return string
     *
     */
    public static function getListVirtualUserRand($id)
    {
        return self::LIST_VIRTUAL_USE_RAND . $id;
    }

    public static function getListInviters()
    {
        return self::LIST_INVITERS;
    }

    /**
     * 异常账号队列
     * @param $userId
     * @return string
     */
    public static function getListExecptionAccount($userId)
    {
        return self::LIST_EXECPTION_ACCOUNT . $userId;
    }

    /**
     * 获取推荐的金牌经纪人列表
     */
    public static function getRecommendMakerList()
    {
        return self::SET_RECOMMEND_MAKER_LIST;
    }

    /**
     * 获取猜你喜欢的类型
     * @param $categoryId
     * @return string
     *
     */
    public static function getSetGuessLikeCategory($categoryId)
    {
        return self::SET_GUESS_LIKE_CATEGORY . $categoryId;
    }

    /**
     * 获取金牌经纪人订单队列
     * @return string
     *
     */
    public static function getMakerOrder()
    {
        return self::LIST_MAKER_ORDER;
    }

    /**
     * 获取金牌经纪人订单结果队列
     * @return string
     *
     */
    public static function getMakerOrderResult()
    {
        return self::HASH_SET_MAKER_ORDER_RESULT;
    }

    /**
     * 获取有偿打卡订单队列
     * @return string
     *
     */
    public static function getPaidClockApplyOrder()
    {
        return self::LIST_PAID_CLOCK_APPLY_ORDER;
    }

    /**
     * 获取获取有偿打卡订单结果队列
     * @return string
     *
     */
    public static function getPaidClockApplyOrderResult()
    {
        return self::HASH_SET_PAID_CLOCK_APPLY_RESULT;
    }

    /**
     * 获取金牌经纪人订单队列
     * @return string
     *
     */
    public static function getNormalOrder()
    {
        return self::LIST_NORMAL_ORDER;
    }

    /**
     * 获取订单结果
     * @return string
     *
     */
    public static function getNormalOrderResult()
    {
        return self::HASH_SET_NORMAL_ORDER_RESULT;
    }

    /**
     * 获取金牌经纪人订单队列
     * @return string
     *
     */
    public static function getSecKillOrder()
    {
        return self::LIST_SEC_KILL_ORDER;
    }

    /**
     * 获取订单结果
     * @return string
     *
     */
    public static function getSecKillOrderResult()
    {
        return self::HASH_SET_SEC_KILL_RESULT;
    }

    /**
     * 获取酒仙优惠券队列
     * @return string
     *
     */
    public static function getWine()
    {
        return self::LIST_GET_WINE;
    }

    /**
     * 获取酒仙优惠券结果
     * @return string
     *
     */
    public static function getWineResult()
    {
        return self::HASH_SET_GET_WINE_RESULT;
    }

    //===============hash start===========================//

    /**
     * 获取区块链主账号缓存Key
     * @return string
     */
    public static function getBlockChainMainAccount()
    {
        return self::HASH_SET_BLOCK_CHAIN_MAIN_ACCOUNT;
    }

    /**
     * 获取区块链合约账号缓存Key
     * @return string
     */
    public static function getBlockChainContractAccount()
    {
        return self::HASH_SET_BLOCK_CHAIN_CONTRACT_ACCOUNT;
    }

    /**
     * Config Key
     * @return string
     */
    public static function getConfig()
    {
        return self::HASH_SET_CONFIG;
    }


    /**
     * Activity Config Key
     * @return string
     */
    public static function getActivityConfig()
    {
        return self::HASH_SET_ACTIVITY_CONFIG;
    }

    /**
     * Config Key
     * @return string
     */
    public static function getVideoConfigs()
    {
        return self::STRING_LOOK_VIDEO_CONFIG;
    }

    /**
     * LookSecond Key
     * @return string
     */
    public static function getVideoLookNumSet()
    {
        return self::HASH_SET_VIDEO_LOOK_NUM_SET;
    }

    /**
     * LookSecond Key
     * @return string
     */
    public static function getLookSecond()
    {
        return self::STRING_LOOK_SECOND;
    }

    /**
     * LookFive Key
     * @return string
     */
    public static function getLookTimeOne()
    {
        return self::STRING_LOOK_FIVE;
    }

    /**
     * LookFifteen
     * @return string
     */
    public static function getLookTimeTwo()
    {
        return self::STRING_LOOK_FIFTEEN;
    }

    /**
     * LookOver
     * @return string
     */
    public static function getLookOver()
    {
        return self::STRING_LOOK_OVER;
    }

    /**
     * VideoStatementSort
     * @return string
     */
    public static function getVideoStatementSort()
    {
        return self::LIST_VIDEO_STATEMENT_SORT;
    }


    public static function getPushNotification()
    {
        return self::LIST_PUSH_NOTIFICATION;
    }

    public static function getListSysMessageCacheKey()
    {
        return self::LIST_SYS_MESSAGE_CACHE;
    }

    public static function getPushMessage()
    {
        return self::LIST_PUSH_MESSAGE;
    }

    /**
     * LookOver
     * @return string
     */
    public static function getVideoLookTime()
    {
        return self::LIST_VIDEO_LOOK_TIME;
    }

    /**
     * 获取商品的库存信息
     * @param $id
     * @return string
     *
     */
    public static function getGoodsStockInfo($id)
    {
        return self::HASH_SET_GOODS_STOCK_INFO . $id;
    }

    //===============hash end===========================//

    /**
     * 统计 - 以周为单位商品浏览数
     * @param int $week 周
     * @return string
     */
    public static function getStatisticGoodsViewsOfWeek($week)
    {
        return self::HASH_SET_STATISTIC_GOODS_VIEWS_WEEK . $week;
    }

    /**
     * 统计 - 以周为单位商品浏览数, 按用户记唯一
     * @param int $week 周
     * @return string
     */
    public static function getStatisticGoodsViewsOfWeekUnique($week)
    {
        return self::HASH_SET_STATISTIC_GOODS_VIEWS_WEEK_UNIQUE . $week;
    }

    /**
     * 获取失效配置
     * @return string
     *
     */
    public static function getEffectConfig()
    {
        return self::HASH_SET_EFFECT_CONFIG;
    }

    //===============set start===========================//
    public static function getUserListOfTag($tag)
    {
        return self::SET_USER_LIST_OF_TAG . $tag;
    }


    //===============set end===========================//

    //===============zset start===========================//

    /**
     * 热门视频排行榜Key
     * @return string
     *
     */
    public static function getSortedSetHotVideoRank()
    {
        return self::SORTED_SET_HOT_VIDEO_RANK;
    }

    /**
     * 红人排行榜KEY
     * @return string
     *
     */
    public static function getSortedSetRedUserRank()
    {
        return self::SORTED_SET_RED_USER_RANK;
    }


    //===============zset end===========================//

    /**
     * 下单锁
     * @param $key
     * @return string
     */
    public static function getOrderLockKey($key)
    {
        return self::getLockKey(self::ORDER_LOCK_KEY . $key);
    }

    /**
     * 退款锁
     * @param $key
     * @return string
     */
    public static function getOrderRefoundLockKey($key)
    {
        return self::getLockKey(self::ORDER_REFOUND_LOCK_KEY . $key);
    }

    /**
     * 发起支付锁
     * @param $key
     * @return string
     *
     */
    public static function getPaymentLockKey($key)
    {
        return self::getLockKey(self::STRING_PAYMENT_LOCK . $key);
    }

    /**
     * 打卡锁
     * @param $key
     * @return string
     *
     */
    public static function getClockLockKey($key)
    {
        return self::getLockKey(self::STRING_CLOCK_LOCK . $key);
    }

    /**
     * 提现申请锁
     * @param $key
     * @return string
     *
     */
    public static function getWithdrawApplyKey($key)
    {
        return self::getLockKey(self::STRING_WITHDRAW_APPLY_LOCK . $key);

    }

    /**
     * 下单锁
     * @param $key
     * @return string
     */
    public static function getSendCouponLockKey($key)
    {
        return self::getLockKey(self::SEND_COUPON_KEY . $key);
    }

    /**
     * 活动排行key
     * @return string
     *
     */
    public static function getSortedActivity($activityId)
    {
        return self::SORTED_SET_RED_ACTIVITY_RANK . $activityId;
    }

    /**
     * 利润最高商品key
     * @return string
     *
     */
    public static function getProfitTopGoods($top)
    {
        return self::SORTED_SET_PROFIT_TOP_GOODS . $top;
    }

    /**
     * 获取收益榜单Key
     * @return string
     *
     */
    public static function getGoldfishRank()
    {
        return self::SORTED_SET_GOLDFISH_RANK;
    }

    /**
     * StringMobileBlack
     * @return string
     */
    public static function getStringMobileBlack($mobile)
    {
        return self::STRING_MOBILE_BLACK . $mobile;
    }

    /**
     * StringMobileBlack
     * @return string
     */
    public static function getTopRedPacketProfit()
    {
        return self::STRING_TOP_RED_PACKET_PROFIT;
    }

    /**
     * 获取收益榜单Key
     * @return string
     *
     */
    public static function getSortSysMessageTypeCache($userId, $type = "", $chiledType = "")
    {
        return self::SORTED_SET_SYS_MESSAGE_TYPE . "{$userId}" . ":{$type}" . ":{$chiledType}";
    }

    /**
     * 获取收益榜单Key
     * @return string
     *
     */
    public static function getSortShopGoodsChannelCache($channel)
    {
        return self::SORTED_SET_SHOP_GOODS_CHANNEL . ":{$channel} ";
    }

    /**
     * 获取收益榜单Key
     * @return string
     *
     */
    public static function getAllSortShopGoodsChannelCache()
    {
        return self::SORTED_SET_SHOP_GOODS_CHANNEL;
    }


    /**
     * 获取秒杀提醒
     * @return string
     *
     */
    public static function getSecKillRemind()
    {
        return self::SEC_KILL_REMIND;
    }

    /**
     * 礼娱赚的总收益
     * @param $userId
     * @return string
     */
    public static function getLockLiveZan($id)
    {
        return self::LOCK_LIVE_ADD_ZAN . $id;
    }

    /**
     * 获取有订单完成的时应商集合
     * @return string
     */
    public static function getSetSupplierOrderSuccess()
    {
        return self::SET_SUPPLIER_ORDER_SUCCESS;
    }

    /**
     * 获取打赏队列
     * @return string
     */
    public static function getLiveReward()
    {
        return self::LIST_LIVE_REWARD;
    }

    /**
     * 活动打赏
     * @return string
     */
    public static function getReportFormReward($id)
    {
        return self::HASH_ACTIVITY_REWARD . $id;
    }

    /**
     * 获取热度队列
     *
     * /* 获取热度队列
     * @return string
     */
    public static function getLiveHeat()
    {
        return self::LIST_LIVE_HEAT;
    }

    /**
     * 获取直播中访客赞num
     * @param $id
     * @return string
     */
    public static function getLiveUniqueVisitorZan($id)
    {
        return self::STRING_LIVE_UNIQUE_VISITOR_ZAN . $id;
    }

    /**
     * 获取new热度队列
     * @return string
     */
    public static function getNewLiveHeat()
    {
        return self::LIST_LIVE_NEW_HEAT;
    }

    /**
     * redis热度
     * @return string
     */
    public static function getLiveRedisHeat()
    {
        return self::HASH_LIVE_REDIS_HEAT;
    }

    /**
     * db热度
     * @return string
     */
    public static function getLiveDbHeat()
    {
        return self::LIST_LIVE_DB_HEAT;
    }

    /**
     * 热度消息
     * @return string
     */
    public static function getLiveHeatMsg()
    {
        return self::LIST_LIVE_HEAT_MSG;
    }

    /**
     * 下单锁
     * @param $key
     * @return string
     */
    public static function getWishLockKey($key)
    {
        return self::getLockKey(self::WISH_LOCK_KEY . $key);
    }

    /**
     * 直播红包相关
     * @param $id
     * @return string
     */
    public static function getStringLiveRedPacket($id)
    {
        return self::STRING_LIVE_RED_PACKET . $id;
    }

    /**
     * 直播红包相关
     * @param $id
     * @return string
     */
    public static function getIncrLiveRedPacket($id)
    {
        return self::INCR_LIVE_RED_PACKET . $id;
    }


    /**
     * 抢红包记录
     * @param $id
     * @return string
     *
     */
    public static function getHashGradRedPacket($id)
    {
        return self::HASH_GRAD_RED_PACKET . $id;
    }

    /**
     * 设置抢红包直播间队列是否正在被监听
     * @param $id
     * @return mixed
     *
     */
    public static function getStringGradLiveRedPacket($id)
    {
        return self::STRING_GRAD_LIVE_RED_PACKET . $id;
    }

    /**
     * 抢红直播间包记录
     * @param $id
     * @return string
     *
     */
    public static function getListGradLiveRedPacket($id)
    {
        return self::LIST_GRAD_LIVE_RED_PACKET . $id;
    }

    /**
     * 抢红直播间包结果记录
     * @param $id
     * @return string
     *
     */
    public static function getHashGradLiveRedPacketResult($id)
    {
        return self::HASH_GRAD_LIVE_RED_PACKET_RESULT . $id;
    }

    /**
     * db热度
     * @return string
     */
    public static function getFansCloseValue()
    {
        return self::LIST_FANS_CLOSE_VALUE;
    }

    /**
     * 获取直播中访客赞（亲密度）
     * @param $id
     * @return string
     */
    public static function getLiveUniqueVisitorZanCloseValue($id)
    {
        return self::STRING_LIVE_UNIQUE_VISITOR_ZAN_CLOSE_VALUE . $id;
    }

    /**
     * 点赞亲密值限制
     * @param $id
     * @return string
     */
    public static function getZanCloseValueLimit($id)
    {
        return self::HASH_ZAN_CLOSE_VALUE_LIMIT . $id;
    }

    /**
     * 消息队列
     * @return string
     */
    public static function getImCallBack()
    {
        return self::LIST_IM_CALL_BACK;
    }

    /**
     * 获取真实的直播数据
     * @param $id
     * @return string
     */
    public static function getRealLiveData($id)
    {
        return self::STRING_LIVE_REAL_DATA . $id;
    }
}
