<?php


namespace common\utils;

use yii\helpers\VarDumper;

class RSAUtil{

    private $privateKey='';//私钥（用于用户加密）
    private $publicKey='';//公钥（用于服务端数据解密）
    private $privateKeyContent = '';
    private $publicKeyContent = '';
    private $privateKeyLen = '';
    private $publicKeyLen = '';

    public function __construct($privatePath, $publicPath){
        $this->privateKeyContent = $this->getContents($privatePath);
        $this->publicKeyContent = $this->getContents($publicPath);
        $this->privateKeyLen = $this->getPrivateKenLen();
        $this->publicKeyLen = $this->getPublicKenLen();
        $this->privateKey = $this->getPrivateKey();//私钥，用于加密
        $this->publicKey = $this->getPublicKey();;//公钥，用于解密
    }

    /**
     * @uses 获取文件内容
     * @param $file_path string
     * @return bool|string
     */
    private function getContents($file_path)
    {
        file_exists($file_path) or die ('密钥或公钥的文件路径错误');
        return file_get_contents($file_path);
    }

    /**
     * @uses 获取公钥长度
     * @param $file_conternt string
     * @return bool|string
     */
    private function getPublicKenLen()
    {
        $pub_id = openssl_get_publickey($this->publicKeyContent);
        return openssl_pkey_get_details($pub_id)['bits'];
    }

    /**
     * @uses 获取私钥长度
     * @param $file_conternt string
     * @return bool|string
     */
    private function getPrivateKenLen()
    {
        $pri_id = openssl_get_privatekey($this->privateKeyContent);
        return openssl_pkey_get_details($pri_id)['bits'];
    }

    /**
     * @uses 获取私钥
     * @return bool|resource
     */
    private function getPrivateKey()
    {
        return openssl_pkey_get_private($this->privateKeyContent);
    }

    /**
     * @uses 获取公钥
     * @return bool|resource
     */
    private function getPublicKey()
    {
        return openssl_pkey_get_public($this->publicKeyContent);
    }


    /**
     * @uses 私钥加密(数据短长都可以)
     * @param string $data
     * @param bool $type(false base64,true为16进制)
     * @return null|string
     */
    public function privateEncrypt($data = '', $type = false)
    {
        if (!is_string($data)) {
            return null;
        }

        $encrypted = '';
        $partLen = $this->publicKeyLen / 8 - 11;
        $parts = str_split($data, $partLen);

        foreach ($parts as $part) {
            $encryptedTemp = '';
            openssl_private_encrypt($part, $encryptedTemp, $this->privateKey);
            $encrypted .= $encryptedTemp;
        }

        $encrypted =  $type ? bin2hex($encrypted) : base64_encode($encrypted);

        return $encrypted;
    }

    /**
     * @uses 私钥解密（数据短长都可以）
     * @param string $encrypted
     * @param bool $type(false base64,true为16进制)
     * @return null
     */
    public function privateDecrypt($encrypted = '', $type = false)
    {
        if (!is_string($encrypted)) {
            return null;
        }

        $decrypted = "";
        $partLen = $this->publicKeyLen / 8;
        $encrypted = $type ? $this->hexToStr($encrypted) : base64_decode($encrypted);
        $parts = str_split($encrypted, $partLen);
        foreach ($parts as $part) {
            $decryptedTemp = '';
            openssl_private_decrypt($part, $decryptedTemp, $this->privateKey);
            $decrypted .= $decryptedTemp;
        }
        return $decrypted;
    }

    /**
     * @uses 公钥加密（数据短长都可以）
     * @param string $data
     * @param bool $type(false base64,true为16进制)
     * @return null|string
     */
    public function publicEncrypt($data = '', $type = false)
    {
        if (!is_string($data)) {
            return null;
        }

        $encrypted = '';
        $partLen = $this->publicKeyLen / 8 - 11;
        $parts = str_split($data, $partLen);

        foreach ($parts as $part) {
            $encryptedTemp = '';
            openssl_public_encrypt($part, $encryptedTemp, $this->publicKey);
            $encrypted .= $encryptedTemp;
        }

        return $type ? bin2hex($encrypted) : base64_encode($encrypted);
    }

    /**
     * @uses 公钥解密（数据短长都可以）
     * @param string $encrypted
     * @return null
     */
    public function publicDecrypt($encrypted = '', $type = false)
    {
        if (!is_string($encrypted)) {
            return null;
        }

        $decrypted = "";
        $partLen = $this->publicKeyLen / 8;
        $base64Decoded = $type ? $this->hexToStr($decrypted) : base64_decode($encrypted);
        $parts = str_split($base64Decoded, $partLen);

        foreach ($parts as $part) {
            $decryptedTemp = '';
            openssl_public_decrypt($part, $decryptedTemp,$this->_getPublicKey());
            $decrypted .= $decryptedTemp;
        }

        return $decrypted;
    }


    /**
     * 私钥加密
     * @param 原始数据 $data
     * @return 密文结果 string
     */
    public function encryptByPrivateKey($data) {
        openssl_private_encrypt($data,$encrypted,$this->privateKey,OPENSSL_PKCS1_PADDING);//私钥加密
        $encrypted = base64_encode($encrypted);//加密后的内容通常含有特殊字符，需要编码转换下，在网络间通过url传输时要注意base64编码是否是url安全的
        return $encrypted;
    }

    /**
     * 私钥解密
     * @param 密文数据 $data
     * @return 原文数据结果 string
     */
    public function decryptByPrivateKey($data){
        $data = base64_decode($data);
        openssl_private_decrypt($data,$encrypted,$this->privateKey,OPENSSL_PKCS1_PADDING);//私钥解密
        return $encrypted;
    }

    /**
     * 私钥解密
     * @param 密文数据 $data
     * @return 原文数据结果 string
     */
    public function decryptByPrivateKeyHex($data){
        $data = hex2bin($data);
        openssl_private_decrypt($data,$encrypted,$this->privateKey,OPENSSL_PKCS1_PADDING);//私钥解密
        return $encrypted;
    }

    /**
     * 私钥签名
     * @param unknown $data
     */
    public function signByPrivateKey($data){
        openssl_sign($data, $signature, $this->privateKey);
        $encrypted = base64_encode($signature);//加密后的内容通常含有特殊字符，需要编码转换下，在网络间通过url传输时要注意base64编码是否是url安全的
        return $encrypted;
    }


    /**
     * 公钥加密
     * @param 原文数据 $data
     * @return 加密结果 string
     */
    public function encryptByPublicKey($data) {
        openssl_public_encrypt($data,$decrypted,$this->publicKey,OPENSSL_PKCS1_PADDING);//公钥加密
        return base64_encode($decrypted);
    }

    /**
     * 公钥加密 hex
     * @param 原文数据 $data
     * @return 加密结果 string
     */
    public function encryptByPublicKeyHex($data) {
        openssl_public_encrypt($data,$decrypted,$this->publicKey,OPENSSL_PKCS1_PADDING);//公钥加密
        return bin2hex($decrypted);
    }

    /**
     * 公钥解密
     * @param 密文数据 $data
     * @return 原文结果 string
     */
    public function decryptByPublicKey($data) {
        $data = base64_decode($data);
        openssl_public_decrypt($data,$decrypted,$this->publicKey,OPENSSL_PKCS1_PADDING);//公钥解密
        return $decrypted;
    }

    /**
     * 公钥验签
     * @param unknown $data
     * @param unknown $sign
     */
    public function verifyByPublicKey($data,$sign){
        $sign = base64_decode($sign);
        return openssl_verify($data, $sign, $this->publicKey);
    }

    public function __destruct(){
        openssl_free_key($this->privateKey);
        openssl_free_key($this->publicKey);
    }

    /**
     * 将字节数组转换成16禁止字符串
     * @param $hex
     * @return string
     */
    private function  hexToStr($hex)
    {
        $string="";
        for   ($i=0;$i<strlen($hex)-1;$i+=2)
            $string.=chr(hexdec($hex[$i].$hex[$i+1]));
        return   $string;
    }


    /**
     **字符串转16进制
     **/
    public function string2Hex($string)
    {
        $hex = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $hex .= dechex(ord($string[$i]));
        }
        return $hex;
    }

}