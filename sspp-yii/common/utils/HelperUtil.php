<?php
/**
 * Created by PhpStorm.
 * User: seven
 * Date: 2019/3/19
 * Time: 上午11:38
 */

namespace common\utils;


use common\constants\CacheKey;
use Faker\Provider\Uuid;
use yii\helpers\BaseInflector;

class HelperUtil extends BaseUtil
{
    public static function getUUID()
    {
        return str_replace('-', '', Uuid::uuid());
    }


    /**
     * 获取随机字符串
     * @param $len
     * @param null $chars
     * @return string
     */
    public static function getRandomString($len, $chars = null)
    {
        if (is_null($chars)) {
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        }
        mt_srand(10000000 * (double)microtime());
        for ($i = 0, $str = '', $lc = strlen($chars) - 1; $i < $len; $i++) {
            $str .= $chars[mt_rand(0, $lc)];
        }
        return $str;
    }

    /**
     * 读取文件指定行内内容
     * @param $filename
     * @param int $startLine
     * @param int $endLine
     * @param string $method
     * @return array|string
     */
    public static function getFileLines($filename, $startLine = 1, $endLine = 50, $method = 'rb')
    {
        $content = array();
        if (version_compare(PHP_VERSION, '5.1.0', '>=')) { // 判断php版本（因为要用到SplFileObject，PHP>=5.1.0）
            $count = $endLine - $startLine;
            $fp = new \SplFileObject($filename, $method);
            $fp->seek($startLine - 1); // 转到第N行, seek方法参数从0开始计数
            for ($i = 0; $i <= $count; ++$i) {
                $content[] = $fp->current(); // current()获取当前行内容
                $fp->next(); // 下一行
            }
        } else { //PHP<5.1
            $fp = fopen($filename, $method);
            if (!$fp)
                return 'error:can not read file';
            for ($i = 1; $i < $startLine; ++$i) { // 跳过前$startLine行
                fgets($fp);
            }

            for ($i; $i <= $endLine; ++$i) {
                $content[] = fgets($fp); // 读取文件行内容
            }
            fclose($fp);
        }
        return array_filter($content); // array_filter过滤：false,null,''
    }


    /**
     * 生成订单号
     * @return string
     * @throws \Exception
     */
    public static function getOrderNo()
    {

        try{
            //redis自增
            $key = CacheKey::getIncrOrderNoDay();
            $redis = new RedisUtil();
            $incrId = $redis->incr($key);

            //雪花算法
            $workerId = 1;
            $idUtil = new IdCreateUtil($workerId);
            $id =  strval($idUtil->nextId()) + $incrId; //防止雪花算法重复

            return $id;
        }catch (\Exception $e){
            throw new \Exception('生成单号异常:'.$e->getMessage());
        }
    }

    /**
     * 创建礼娱号
     * @return mixed
     */
    public static function createAccount()
    {
        return HelperUtil::getUUID();
    }

    /**
     * 高精度加法
     * @param string $leftOperand
     * @param string $rightOperand
     * @param int $scale 保留位数
     * @return string
     */
    public static function jia($leftOperand, $rightOperand, $scale = 2)
    {
        return bcadd(strval($leftOperand), strval($rightOperand), intval($scale));
    }

    /**
     * 高精度减法
     * @param $leftOperand
     * @param $rightOperand
     * @param int $scale 保留位数
     * @return string
     */
    public static function jian($leftOperand, $rightOperand, $scale = 2)
    {
        return bcsub(strval($leftOperand), strval($rightOperand), intval($scale));
    }

    /**
     * 高精度乘法
     * @param string $leftOperand
     * @param string $rightOperand
     * @param int $scale 保留位数
     * @return string
     */
    public static function cheng($leftOperand, $rightOperand, $scale = 2)
    {
        return bcmul(strval($leftOperand), strval($rightOperand), intval($scale));
    }

    /**
     * 高精度除法
     * @param $leftOperand
     * @param $rightOperand
     * @param int $scale 保留位数
     * @return string
     */
    public static function chu($leftOperand, $rightOperand, $scale = 2)
    {
        return bcdiv(strval($leftOperand), strval($rightOperand), intval($scale));
    }

    /**
     * 高精度比较
     * @param string $leftOperand
     * @param string $rightOperand
     * @param int $scale 用来作比较的小数点部分
     * @return int  0：相等  <0(-1)：$leftOperand<$rightOperand  >0(1):$leftOperand > $rightOperand
     */
    public static function compare($leftOperand, $rightOperand, $scale = 2)
    {
        return bccomp(strval($leftOperand), strval($rightOperand), intval($scale));
    }

    /**
     * 高精度取模
     * @param $leftOperand
     * @param $modulus
     * @return string
     */
    public static function mod($leftOperand, $modulus)
    {
        return bcmod(strval($leftOperand), strval($modulus));
    }

    /**
     * 高精度数字的乘方
     * @param $leftOperand
     * @param $rightOperand
     * @param int $scale
     * @return string
     */
    public static function pow($leftOperand, $rightOperand, $scale = 2)
    {
        return bcpow(strval($leftOperand), strval($rightOperand), intval($scale));
    }

    /**
     * 高精度操作数的二次方根
     * @param $operand
     * @param int $scale
     * @return string
     */
    public static function sqrt($operand, $scale = 2)
    {
        return bcsqrt(strval($operand), intval($scale));
    }

    /**
     * 处理文件地址
     * @param $file
     * @return string
     */
    public static function doFileUrl($file)
    {
        return $file ? rtrim(\Yii::$app->params['storageDomain'], '/') . '/' . ltrim($file, "/") : "";
    }

    /**
     * 图片缩略图
     * @param $img
     * @param $weight
     * @param $height
     * @return string
     */
    public static function doThumbnail($img,$weight=350,$height=350){
        return $img ? rtrim(\Yii::$app->params['thumbnail'], '/') . '/' . ltrim($img, "/")."?imageView2/1/w/".$weight."/h/".$height : "";
    }

    /**
     * 获取随机种子数
     * @return int
     */
    public static function getSeed()
    {
        $hash = self::getUUID();
        return ord(substr($hash, -1));
    }

    public static function hideMobile($mobile)
    {
        return substr($mobile, 0, 3) . "****" . substr($mobile, 7, 4);
    }

    /**
     * 移除图片前面域名
     * @param $imagePath
     * @return string
     */
    public static function removeImageDomain($imagePath)
    {
        $tmp = explode('images', $imagePath);
        $imagePath = end($tmp);
        return 'images' . $imagePath;
    }
    
    /**
     * 移除URL中的协议和域名部分, 返回uri
     * @param string $url 欲处理的URL
     * @return string 成功返回uri
     */
    public static function removeDomain($url) {
        $uri = preg_replace('#^((http://)|(https://))?([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}(/)#', '', $url);
        return $uri;
    }

    /**
     * 格式化，保留2位小数
     * @param $num
     * @param int $wei
     * @return string
     */
    public static function numberFormat($num, $wei = 2)
    {
        return HelperUtil::cheng($num, 1, $wei);
    }

    /**
     * 获取小视频访问连接
     * @param $videoUrl
     * @return string
     */
    public static function getVisitVidelUrl($videoUrl)
    {

        if (empty($videoUrl)) {
            return "";
        }

        $key = \Yii::$app->params['smallVideoAuthKey'];
        $tmp = explode('/', $videoUrl);
        unset($tmp[count($tmp) - 1]);
        $dir = '/' . implode('/', $tmp) . '/';
        $validTime = time() + 86400;//有效一天时间
        $t = strtolower(base_convert($validTime, 10, 16));
        $us = self::getRandomString(10);
        $sign = md5($key . $dir . $t . $us);

        $videoUrl = \Yii::$app->params['smallVideoDomain'] . '/' . ltrim($videoUrl, '/');

        return $videoUrl . '?t=' . $t . '&us=' . $us . '&sign=' . $sign;
    }

    /**
     * 是否靓号
     * @param $number
     * @return boolean
     */
    public static function isGoodNumber($number)
    {
        $len = strlen($number);
        $temp = intval(str_repeat(1, $len));
        // 对相应位数的1，取模，如果为0则，表示为靓号。比如：222/111 = 0 ，444444/111111 = 0
        // 判断 AAA AAAA AAAAA
        if ($number % $temp == 0) {
            return true;
        }

        // 判断格式 AABB AAABBB AAAABBBB
        if ($len % 2 == 0) {
            $half = $len / 2;
            $temp = intval(str_repeat(1, $half));
            $part1 = intval(substr($number, 0, $half));
            $part2 = intval(substr($number, $half, $half));
            if ($part1 % $temp == 0 && $part2 % $temp == 0) {
                return true;
            }
        }

        // 判断格式 AABBCC AAABBBCCC AAAABBBBCCCC
        if ($len % 3 == 0) {
            $half = $len / 3;
            $temp = intval(str_repeat(1, $half));
            $part1 = substr($number, 0, $half);
            $part2 = substr($number, $half, $half);
            $part3 = substr($number, $half * 2, $half);
            if ($part1 % $temp == 0 && $part2 % $temp == 0 && $part3 % $temp == 0) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * 将大小写的数组KEY转换为下划线式的KEY
     * @param array $array 欲转换的数组
     * @return array 转换后的数组
     */
    public static function keyToUnderscore(array $array) {
        $ret = [];
        if (empty($array)) {
            return $array;
        }
        
        foreach ($array as $key => $value) {
            $newKey = BaseInflector::underscore($key);
            $ret[$newKey] = $value;
        }
        
        return $ret;
    }
    
    /**
     * 将下划线的数组KEY转换为大小写式的KEY
     * @param array $array 欲转换的数组
     * @param boolean $lcFirst 首字母是否小写, true 是; false 否.
     * @return array 转换后的数组
     */
    public static function keyToUcwords(array $array, $lcFirst = true) {
        $ret = [];
        if (empty($array)) {
            return $array;
        }
        
        foreach ($array as $key => $value) {
            $newKey = str_replace('_', '', ucwords($key, '_'));
            if ($lcFirst) {
                $newKey = lcfirst($newKey);
            }
            $ret[$newKey] = $value;
        }
        
        return $ret;
    }

}