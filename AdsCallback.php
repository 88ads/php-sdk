<?php

/**
 * 88ads移动广告联盟 注册转化数据回传API
 * Class AdsCallback
 * @package app\services
 */
class AdsCallback
{
    private $appKey; //appKey
    private $appSecret; //secret

    const REG_CALLBACK_URL = 'http://www.88ads.com/callback/reg?';

    public function __construct($appKey, $appSecret)
    {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
    }

    public function sendRegCallback($channel, $regTime, $regIp)
    {
        $appKey = $this->appKey;
        $appSecret = $this->appSecret;
        $timestamp = time();
        $nonce = $this->getRandomStr();
        $data = [
            "channel" => $channel,
            "regTime" => $regTime,
            "regIp" => $regIp,
            "appSecret" => $appSecret,
            "appKey" => $appKey,
            "timestamp" => $timestamp,
            'nonce' => $nonce
        ];
        $sign = $this->sign($data);
        unset($data['appSecret']);
        $data['sign'] = $sign;

        $url = self::REG_CALLBACK_URL . http_build_query($data);
        $ret =  $this->httpGet($url);
        return json_decode($ret, true);
    }

    /**
     * 对数组签名
     * @param $array
     * @return string
     */
    public function sign(array $array)
    {
        ksort($array);
        $string = "";
        foreach ($array as $key => $val) {
            $string .= $val;
        }
        return md5($string);
    }

    /**
     * HTTP GET 请求
     * @param $url
     * @return mixed
     * @throws \Exception
     */
    public function httpGet($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
            throw new \Exception('url is invalid');
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    /**
     * 随机生成字符串
     * @param int $length
     * @return string 生成的字符串
     */
    public function getRandomStr($length = 8)
    {
        $str = "";
        $str_pol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($str_pol) - 1;
        for ($i = 0; $i < $length; $i++) {
            $str .= $str_pol[mt_rand(0, $max)];
        }
        return $str;
    }
}