# 88ADS SDK for PHP

# 第一步：获取appKey以及appSecret
	广告主后台->转化设置->复制appKey以及appSecret。请妥善保管密钥。

![image](https://github.com/88ads/php-sdk/blob/master/img/screenshot.png)

# 第二步：设置渠道ID
	广告主后台->计划管理->任意选中一个广告->编辑
	
# 第三步：反馈注册数据
	当用户注册后，广告主需要向88ads移动广告联盟发送以下数据：
	*$channel 用户注册的渠道ID
	*$regTime 用户注册时间(10位UNIX时间戳)
	*$regIp 用户IP地址

# PHP SDK使用DEMO：
```php
require 'AdsCallback.php';

$appKey = '你的appKey';
$appSecret = '你的appSecret';
$channel = '渠道ID';
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
···json
{"code":403,"msg":"signVerify failed","data":[]}
···
	