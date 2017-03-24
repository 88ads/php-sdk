# 88ADS SDK for PHP

# 第一步：获取appKey以及appSecret
	广告主后台->转化设置->复制appKey以及appSecret。请妥善保管密钥。

![image](https://github.com/88ads/php-sdk/blob/master/img/screenshot.png)

# 第二步：设置渠道ID
    每个广告需要设置一个渠道ID，不可重复
	广告主后台->计划管理->添加/编辑广告
![image](https://github.com/88ads/php-sdk/blob/master/img/qd.png)

# PHP SDK使用DEMO：
```php
require 'AdsCallback.php';

$appKey = '你的appKey';
$appSecret = '你的appSecret';
$channel = '注册渠道ID';
$regTime = '注册时间';
$regIp = '注册IP';

$callback = new AdsCallback($appKey, $appSecret);
$data = $callback->sendRegCallback($channel, $regTime, $regIp);
```

	成功返回的数据格式如下：
```json
{"code":200,"msg":"success","data":[]}
```

	失败返回的数据格式如下：
```json
{"code":403,"msg":"signVerify failed","data":[]}
```

# 其他平台：
	Android、IOS和其他平台请自行构造请求向我们的接口发送数据。格式如下：
	http://www.88ads.com/callback/reg?channel=qx8888&regTime=1490165651&regIp=192.168.1.111&appKey=d110210320e7bbdcf63ac0e6f7f26d53&timestamp=1490165651&nonce=WGxPhzTE&sign=52b20e1775ea7b4a46af8e514067d8b2
	
# 参数说明
```
    * channel 渠道ID
    * regTime 注册时间
    * regIp 注册IP
    * appKey 你的APPKEY
    * timestamp 当前时UNIX间戳 10位
    * nonce 随机字符串
    * sign 签名
```
	
# 签名方法
    将如下参数组成一个数组或者map
```php
$data = [
    "channel" => $channel,
    "regTime" => $regTime,
    "regIp" => $regIp,
    "appSecret" => $appSecret,
    "appKey" => $appKey,
    "timestamp" => $timestamp,
    'nonce' => $nonce
];
```

    按照key进行排序
```php
    ksort($data);
```


    将排好序的数组或者map拼成一个字符串，最后进行md5加密，最终得到sign
```php
    $string = "";
    foreach ($data as $key => $val) {
        $string .= $val;
    }
    $sign = md5($string);
```

    