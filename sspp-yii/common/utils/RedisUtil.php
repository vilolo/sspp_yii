<?php
/**
 * Created by PhpStorm.
 * User: seven
 * Date: 2019/3/19
 * Time: 上午9:49.
 */

namespace common\utils;
use yii\redis;

use Yii;

class RedisUtil extends BaseUtil
{
    /**
     * yii\redis
     * @var yii\redis
     */
    private $_redis;

    const LOCK_SUCCESS = "OK";

    private $lockeds = [];

    public function __construct()
    {
        $this->_redis = Yii::$app->redis;
    }

    /*****************hash表操作函数*******************/

    /**
     * 得到hash表中一个字段的值
     *
     * @param string $key 缓存key
     * @param string $field 字段
     *
     * @return string|false
     */
    public function hGet($key, $field)
    {
        return $this->_redis->hget($key, $field);
    }

    /**
     * 为hash表设定一个字段的值
     *
     * @param string $key 缓存key
     * @param string $field 字段
     * @param string $value 值
     *
     * @return bool
     */
    public function hSet($key, $field, $value)
    {
        return $this->_redis->hset($key, $field, $value);
    }

    /**
     * 判断hash表中，指定field是不是存在.
     *
     * @param string $key 缓存key
     * @param string $field 字段
     *
     * @return bool
     */
    public function hExists($key, $field)
    {
        return $this->_redis->hexists($key, $field);
    }

    /**
     * 删除hash表中指定字段 ,支持批量删除.
     *
     * @param string $key 缓存key
     * @param string $field 字段
     *
     * @return int
     */
    public function hdel($key, $field)
    {
        $fieldArr = explode(',', $field);
        $delNum = 0;

        foreach ($fieldArr as $row) {
            $row = trim($row);
            $delNum += $this->_redis->hdel($key, $row);
        }

        return $delNum;
    }

    /**
     * 返回hash表元素个数.
     *
     * @param string $key 缓存key
     *
     * @return int|bool
     */
    public function hLen($key)
    {
        return $this->_redis->hlen($key);
    }

    /**
     * 为hash表设定一个字段的值,如果字段存在，返回false.
     *
     * @param string $key 缓存key
     * @param string $field 字段
     * @param string $value 值
     *
     * @return bool
     */
    public function hSetNx($key, $field, $value)
    {
        return $this->_redis->hsetnx($key, $field, $value);
    }

    /**
     * 为hash表多个字段设定值。
     *
     * @param string $key
     * @param array $value
     *
     * @return array|bool
     */
    public function hMset($key, ...$value)
    {
        return $this->_redis->hmset($key, ...$value);
    }

    /**
     * 批量取值
     *
     * @param string $key
     * @param $field
     *
     * @return array|bool
     */
    public function hMget($key, ...$field)
    {
        return $this->_redis->hmget($key, ...$field);
    }

    /**
     * 批量取值 - 数组式
     * @param string $key
     * @param array $fieldArr 欲获取HKEY的数组
     * @return array 返回值为HKEY为KEY的数组
     * @throws \Exception
     */
    public function hMgetArray($key, array $fieldArr)
    {
        $data = $this->_redis->hmget($key, ...$fieldArr);
        if (!is_array($data) || !isset($data[0])) {
            throw new \Exception('Redis错误');
        }

        $result = [];
        foreach ($fieldArr as $index => $hKey) {
            $result[$hKey] = $data[$index];
        }

        return $result;
    }

    /**
     * 为hash表设这累加，可以负数.
     *
     * @param string $key
     * @param int $field
     * @param string $value
     *
     * @return bool
     */
    public function hIncrBy($key, $field, $value)
    {
        $value = intval($value);

        return $this->_redis->hincrby($key, $field, $value);
    }

    /**
     * 返回所有hash表的所有字段.
     *
     * @param string $key
     *
     * @return array|bool
     */
    public function hKeys($key)
    {
        return $this->_redis->hkeys($key);
    }

    /**
     * 返回所有hash表的字段值，为一个索引数组.
     *
     * @param string $key
     *
     * @return array|bool
     */
    public function hVals($key)
    {
        return $this->_redis->hvals($key);
    }

    /**
     * 返回所有hash表的字段值，为一个关联数组.
     *
     * @param string $key
     *
     * @return array|bool
     */
    public function hGetAll($key)
    {
        $result = $this->_redis->hgetall($key);
        $map = [];
        if ($result) {
            for ($i = 0; $i < count($result); $i++) {
                if ($i % 2 > 0) continue;
                $map[$result[$i]] = $result[$i + 1];
            }
        }
        return $map;
    }

    /**
     * 迭代遍历HASH
     * @param string $key
     * @param int & $cursor 游标, 传递变量获取迭代到新位置
     * @param string $pattern [optional] 匹配规则
     * @param int $count [optional] 限制取回量(在HASH集合中元素较少时无效)
     * @return array 返回以HKEY为KEY的数组
     * @throws \Exception
     */
    public function hScan($key, & $cursor, $pattern = null, $count = null)
    {
        $params = [$key, $cursor];
        if (null !== $pattern) {
            $params[] = 'MATCH';
            $params[] = $pattern;
        }

        if (null !== $count) {
            $params[] = 'COUNT';
            $params[] = $count;
        }

        $data = $this->_redis->executeCommand('HSCAN', $params);
        if (!is_array($data) || !isset($data[0])) {
            throw new \Exception('Redis错误');
        }

        $cursor = $data[0];

        $result = [];
        if (isset($data[1])) {
            $hKey = '';
            foreach ($data[1] as $index => $value) {
                if (0 == $index % 2) {
                    $hKey = $value;
                } else {
                    $result[$hKey] = $value;
                }
            }
        }

        return $result;
    }

    /*********************有序集合操作*********************/

    /**
     * 给当前集合添加一个元素
     * 如果value已经存在，会更新order的值。
     *
     * @param string $key
     * @param string $order 序号
     * @param string $value 值
     *
     * @return bool
     */
    public function zAdd($key, $order, $value)
    {
        return $this->_redis->zadd($key, $order, $value);
    }

    /**
     * 给$value成员的order值，增加$num,可以为负数.
     *
     * @param string $key
     * @param string $num 序号
     * @param string $value 值
     *
     * @return mixed
     */
    public function zinCry($key, $num, $value)
    {
        return $this->_redis->zincry($key, $num, $value);
    }

    /**
     * 删除值为value的元素.
     *
     * @param string $key
     * @param string $value
     *
     * @return bool
     */
    public function zRem($key, $value)
    {
        return $this->_redis->zrem($key, $value);
    }

    /**
     * 删除值为value的元素.
     *
     * @param string $key
     * @param string $value
     *
     * @return bool
     */
    public function zRemKey($key)
    {
        return $this->_redis->zrem($key);
    }

    /**
     * 集合以order递增排列后，0表示第一个元素，-1表示最后一个元素.
     *
     * @param string $key
     * @param int $start
     * @param int $end
     *
     * @return array|bool
     */
    public function zRange($key, $start, $end)
    {
        return $this->_redis->zrange($key, $start, $end);
    }

    /**
     * 集合以order递减排列后，0表示第一个元素，-1表示最后一个元素.
     *
     * @param string $key
     * @param int $start
     * @param int $end
     *
     * @return array|bool
     */
    public function zRevRange($key, $start, $end)
    {
        return $this->_redis->zrevrange($key, $start, $end);
    }

    /**
     * 移除有序集合
     * @param $key
     * @param $start
     * @param $end
     * @return mixed
     */
    public function zRemRangeByRank($key, $start, $end)
    {
        return $this->_redis->ZREMRANGEBYRANK($key, $start, $end);
    }

    /**
     * 集合以order递增排列后，返回指定order之间的元素。
     * min和max可以是-inf和+inf　表示最大值，最小值
     *
     * @param string $key
     * @param  $start
     * @param  $end
     *
     * @return array|bool
     */
    public function zRangeByScore($key, $start = '-inf', $end = '+inf', $options = [])
    {
        $params = [];
        if (isset($options['withscores']) && $options['withscores']) {
            $params[] = 'WITHSCORES';
        }

        if (isset($options['limit'])) {
            $params[] = 'LIMIT';
            if (isset($options['offset'])) {
                $params[] = $options['offset'];
            } else {
                $params[] = 0;
            }

            $params[] = $options['limit'];
        }
        return $this->_redis->zrangebyscore($key, $start, $end, ...$params);
    }

    /**
     * 集合以order递减排列后，返回指定order之间的元素。
     * min和max可以是-inf和+inf　表示最大值，最小值
     *
     * @param string $key
     * @param  $start
     * @param  $end
     *
     * @return array|bool
     */
    public function zRevRangeByScore($key, $start = '-inf', $end = '+inf', $options = [])
    {
        $params = [];
        if (isset($options['withscores']) && $options['withscores']) {
            $params[] = 'WITHSCORES';
        }

        if (isset($options['limit'])) {
            $params[] = 'LIMIT';
            if (isset($options['offset'])) {
                $params[] = $options['offset'];
            } else {
                $params[] = 0;
            }

            $params[] = $options['limit'];
        }

        return $this->_redis->zrevrangebyscore($key, $start, $end, ...$params);
    }

    /**
     * 返回order值在start end之间的数量.
     *
     * @param $key
     * @param $start
     * @param $end
     *
     * @return mixed
     */
    public function zCount($key, $start, $end)
    {
        return $this->_redis->zcount($key, $start, $end);
    }

    /**
     * 返回值为value的order值
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function zScore($key, $value)
    {
        return $this->_redis->zscore($key, $value);
    }

    /**
     * 返回集合以score递增加排序后，指定成员的排序号，从0开始。
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function zRank($key, $value)
    {
        return $this->_redis->zrank($key, $value);
    }

    /**
     * 返回集合以score递增加排序后，指定成员的排序号，从0开始。
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function zRevRank($key, $value)
    {
        return $this->_redis->zrevrank($key, $value);
    }

    /**
     * 删除集合中，score值在start end之间的元素　包括start end
     * min和max可以是-inf和+inf　表示最大值，最小值
     *
     * @param $key
     * @param $start
     * @param $end
     *
     * @return mixed
     */
    public function zRemRangeByScore($key, $start, $end)
    {
        return $this->_redis->zremrangebyscore($key, $start, $end);
    }

    /**
     * 返回集合元素个数。
     *
     * @param $key
     *
     * @return mixed
     */
    public function zCard($key)
    {
        return $this->_redis->zcard($key);
    }

    /*********************队列操作命令************************/

    /**
     * 在队列尾部插入一个元素.
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function rPush($key, $value)
    {
        return $this->_redis->rpush($key, $value);
    }

    /**
     * 在队列尾部插入一个元素 如果key不存在，什么也不做.
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function rPushx($key, $value)
    {
        return $this->_redis->rpushx($key, $value);
    }

    /**
     * 在队列头部插入一个元素.
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function lPush($key, $value)
    {
        return $this->_redis->lpush($key, $value);
    }

    /**
     * 在队列头插入一个元素 如果key不存在，什么也不做.
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function lPushx($key, $value)
    {
        return $this->_redis->lpushx($key, $value);
    }

    /**
     * 返回队列长度.
     *
     * @param $key
     *
     * @return mixed
     */
    public function lLen($key)
    {
        return $this->_redis->llen($key);
    }

    /**
     * 返回队列指定区间的元素.
     *
     * @param $key
     * @param $start
     * @param $end
     *
     * @return mixed
     */
    public function lRange($key, $start, $end)
    {
        return $this->_redis->lrange($key, $start, $end);
    }

    /**
     * 返回队列中指定索引的元素.
     *
     * @param $key
     * @param $index
     *
     * @return mixed
     */
    public function lIndex($key, $index)
    {
        return $this->_redis->lindex($key, $index);
    }

    /**
     * 设定队列中指定index的值。
     *
     * @param $key
     * @param $index
     * @param $value
     *
     * @return mixed
     */
    public function lSet($key, $index, $value)
    {
        return $this->_redis->lset($key, $index, $value);
    }

    /**
     * 删除值为vaule的count个元素
     * PHP-REDIS扩展的数据顺序与命令的顺序不太一样，不知道是不是bug
     * count>0 从尾部开始
     *  >0　从头部开始
     *  =0　删除全部.
     *
     * @param $key
     * @param $count
     * @param $value
     *
     * @return mixed
     */
    public function lRem($key, $count, $value)
    {
        return $this->_redis->lrem($key, $count, $value);
    }

    /**
     *  删除并返回队列中的头元素。
     *
     * @param $key
     *
     * @return mixed
     */
    public function lPop($key)
    {
        return $this->_redis->lpop($key);
    }

    /**
     * 删除并返回队列中的尾元素.
     *
     * @param $key
     *
     * @return mixed
     */
    public function rPop($key)
    {
        return $this->_redis->rpop($key);
    }

    /**
     * 删除并返回队列中的尾元素.
     *
     * @param $key
     * @param $timeout
     *
     * @return mixed
     */
    public function bRPop($key, $timeout = 0)
    {
        try {
            return $this->_redis->brpop($key, $timeout);
        }
        catch (yii\redis\SocketException $e) {
            return false;
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 只保留start到stop区间的（包含start、stop）.
     *
     * @param $key
     * @param $start
     * @param $stop
     *
     * @return mixed]
     */
    public function ltrim($key, $start, $stop)
    {
        return $this->_redis->ltrim($key, $start, $stop);
    }

    /*************redis字符串操作命令*****************/

    /**
     * 设置一个key.
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function set($key, $value)
    {
        return $this->_redis->set($key, $value);
    }

    /**
     * 设置一个key.
     *
     * @param $key
     * @param $options
     *
     * @return mixed
     */
    public function setByOptions($key, ...$options)
    {
        return $this->_redis->set($key, $options);
    }

    /**
     * 得到一个key.
     *
     * @param $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->_redis->get($key);
    }

    /**
     * 加一操作
     * @param $key
     * @return mixed
     */
    public function incr($key)
    {
        return $this->_redis->incr($key);
    }

    /**
     *加n操作
     * @param $key
     * @return mixed
     */
    public function incrby($key, $num)
    {
        return $this->_redis->incrby($key, $num);
    }

    /**
     * 设置一个有过期时间的key.
     *
     * @param $key
     * @param $expire
     * @param $value
     *
     * @return mixed
     */
    public function setex($key, $expire, $value)
    {
        return $this->_redis->setex($key, $expire, $value);
    }

    /**
     * 设置一个key,如果key存在,不做任何操作.
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function setnx($key, $value, $expire = 0)
    {
        return $expire ? $this->_redis->set($key, $value, "ex", $expire, "nx") : $this->_redis->setnx($key, $value);
    }

    /**
     * 批量设置key.
     *
     * @param $arr
     *
     * @return mixed
     */
    public function mset($arr)
    {
        return $this->_redis->mset($arr);
    }

    /*************redis　无序集合操作命令*****************/

    /**
     *  返回集合中所有元素.
     *
     * @param $key
     *
     * @return mixed
     */
    public function sMembers($key)
    {
        return $this->_redis->smembers($key);
    }

    /**
     * 求2个集合的差集.
     *
     * @param $key1
     * @param $key2
     *
     * @return mixed
     */
    public function sDiff($key1, $key2)
    {
        return $this->_redis->sdiff($key1, $key2);
    }

    /**
     * 添加集合。由于版本问题，扩展不支持批量添加。这里做了封装.
     *
     * @param $key
     * @param $value
     */
    public function sAdd($key, $value)
    {
        if (!is_array($value)) {
            $arr = array($value);
        } else {
            $arr = $value;
        }
        foreach ($arr as $row) {
            $this->_redis->sadd($key, $row);
        }
    }

    public function sAddRaw($key, ...$members)
    {
        return $this->_redis->sadd($key, ...$members);
    }

    /**
     * 返回无序集合的元素个数.
     *
     * @param $key
     *
     * @return mixed
     */
    public function scard($key)
    {
        return $this->_redis->scard($key);
    }

    /**
     * 从集合中删除一个元素.
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function srem($key, $value)
    {
        return $this->_redis->srem($key, $value);
    }

    /**
     * 移除并返回集合中的一个随机元素
     * @param $key
     * @return mixed
     */
    public function sPop($key)
    {
        return $this->_redis->spop($key);
    }

    /**
     * 迭代遍历SET
     * @param string $key
     * @param int & $cursor 游标, 传递变量获取迭代到新位置
     * @param string $pattern [optional] 匹配规则
     * @param int $count [optional] 限制取回量(在集合中元素较少时无效)
     * @return array 元素数组
     * @throws \Exception
     */
    public function sScan($key, & $cursor, $pattern = null, $count = null)
    {
        $params = [$key, $cursor];
        if (null !== $pattern) {
            $params[] = 'MATCH';
            $params[] = $pattern;
        }

        if (null !== $count) {
            $params[] = 'COUNT';
            $params[] = $count;
        }

        $data = $this->_redis->executeCommand('SSCAN', $params);
        if (!is_array($data) || !isset($data[0])) {
            throw new \Exception('Redis错误');
        }

        $cursor = $data[0];

        return $data[1];
    }

    /**
     * 将多个SET求并集存放到目标集合
     * @param string $destination
     * @param string ...$keys
     * @return mixed
     */
    public function sUnionStore($destination, ...$keys)
    {
        return $this->_redis->sunionstore($destination, ...$keys);
    }

    /**
     * 将多个SET求交集存放到目标集合
     * @param string $destination
     * @param string ...$keys
     * @return mixed
     */
    public function sInterStore($destination, ...$keys)
    {
        return $this->_redis->sinterstore($destination, ...$keys);
    }

    /**
     * 检测$member是否在集合内
     * @param string $key
     * @param string $member
     * @return boolean 在返回true; KEY不存在或$member不在集合内返回false
     */
    public function sIsMember($key, $member)
    {
        return (bool)$this->_redis->sinterstore($key, $member);
    }

    /*************redis管理操作命令*****************/

    /**
     *  删除指定key.
     *
     * @param $key
     *
     * @return bool
     */
    public function del($key)
    {
        if (!$this->exists($key))
            return true;
        return $this->_redis->del($key);
    }

    /**
     *  判断一个key值是不是存在.
     *
     * @param $key
     *
     * @return mixed
     */
    public function exists($key)
    {
        return $this->_redis->exists($key);
    }

    /**
     * 为一个key设定过期时间 单位为秒.
     *
     * @param $key
     * @param $expire
     *
     * @return mixed
     */
    public function expire($key, $expire)
    {
        return $this->_redis->expire($key, $expire);
    }

    /**
     * 设定一个key什么时候过期，time为一个时间戳.
     *
     * @param $key
     * @param $time
     *
     * @return mixed
     */
    public function exprieAt($key, $time)
    {
        return $this->_redis->expireat($key, $time);
    }

    /**
     * 返回一个key还有多久过期，单位秒.
     *
     * @param $key
     *
     * @return mixed
     */
    public function ttl($key)
    {
        return $this->_redis->ttl($key);
    }

    /*********************事务的相关方法************************/

    /**
     * 监控key,就是一个或多个key添加一个乐观锁
     * 在此期间如果key的值如果发生的改变，刚不能为key设定值
     * 可以重新取得Key的值。
     *
     * @param $key
     *
     * @return mixed
     */
    public function watch($key)
    {
        return $this->_redis->watch($key);
    }

    /**
     * 取消当前链接对所有key的watch
     *  EXEC 命令或 DISCARD 命令先被执行了的话，那么就不需要再执行 UNWATCH 了.
     */
    public function unwatch()
    {
        return $this->_redis->unwatch();
    }

    /**
     * 开启一个事务
     * 事务的调用有两种模式Redis::MULTI和Redis::PIPELINE，
     * 默认是Redis::MULTI模式，
     * Redis::PIPELINE管道模式速度更快，但没有任何保证原子性有可能造成数据的丢失.
     */
    public function multi()
    {
        return $this->_redis->multi();
    }

    /**
     * 执行一个事务
     * 收到 EXEC 命令后进入事务执行，事务中任意命令执行失败，其余的命令依然被执行.
     */
    public function exec()
    {
        return $this->_redis->exec();
    }

    /**
     * 回滚一个事务
     */
    public function discard()
    {
        return $this->_redis->discard();
    }

    /**
     * 测试当前链接是不是已经失效
     * 没有失效返回+PONG
     * 失效返回false.
     */
    public function ping()
    {
        return $this->_redis->ping();
    }

    /**
     * 加锁
     * @param string $key 锁的标识名
     * @param int $timeout 循环获取锁的等待超时时间，在此时间内会一直尝试获取锁直到超时，为0表示失败后直接返回不等待
     * @param int $expire 当前锁的最大生存时间(秒)，必须大于0，如果超过生存时间锁仍未被释放，则系统会自动强制释放
     * @param int $waitInterval 获取锁失败后挂起再试的时间间隔(微秒)
     * @return bool
     *
     */
    public function lock($key, $timeout = 0, $expire = 1, $waitInterval = 1000)
    {
        $now = time();
        $timeoutAt = $now + $timeout;  // 获取锁失败时的等待超时时刻
        $expireAt = $now + $expire;    // 锁的最大生存时刻

        while (true) {
            // 将Key的最大生存时刻存到redis里，过了这个时刻该锁会被自动释放
            $result = $this->setnx($key, $expireAt, $expire);

            if ($result !== false && $result !== null) {
                $this->lockeds[$key] = $expireAt;          // 将锁标志放到locks数组里
                return true;
            }

            // 以秒为单位，返回给定key的剩余生存时间
            $ttl = $this->ttl($key);

            /*
             * ttl小于0 表示key上没有设置生存时间（key是不会不存在的，因为前面setnx会自动创建）
             * 如果出现这种状况，那就是进程的某个实例setnx成功后 crash 导致紧跟着的expire没有被调用
             * 这时可以直接设置expire并把锁纳为己用
             * */
            if ($ttl < 0) {
                $this->setex($key, $expire, $expireAt);
                $this->lockeds[$key] = $expireAt;
                return true;
            }

            /*****循环请求锁部分*****/
            //如果没设置锁失败的等待时间 或者 已超过最大等待时间了，那就退出
            if ($timeout <= 0 || $timeoutAt < microtime(true)) break;

            //隔 $waitInterval 后继续 请求
            usleep($waitInterval);
        }

        return false;
    }

    /**
     * 解锁
     * @param $key
     * @return bool
     *
     */
    public function unlock($key)
    {
        //先判断是否存在此锁
        if (isset($this->lockeds[$key])) {
            //删除锁
            if ($this->del($key)) {
                //清掉lockedNames里的锁标志
                unset($this->lockeds[$key]);
                return true;
            }
        }
        return false;
    }

    /**
     * 释放当前所有获得的锁
     * @param $key
     * @return bool
     */
    public function clearLock($key)
    {
        $this->lockeds = [];
        $this->del($key);
        return true;
    }

    #region 发布和订阅

    /**
     * 发布
     * @param $key
     * @param $message
     * @return mixed
     *
     */
    public function publish($key, $message)
    {
        return $this->_redis->publish($key, $message);
    }

    /**
     * 订阅
     * @param $keys
     * @param $callback
     * @return mixed
     *
     */
    public function subscribe($keys, $callback)
    {
        if (is_string($keys)) {
            $keys = [$keys];
        }
        return $this->_redis->subscribe($keys, $callback);
    }

    #endreigon
}
