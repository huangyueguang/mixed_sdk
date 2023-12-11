# 各游戏渠道服务器接入sdk

#### 引入方式
##### 	使用composer引入
​`composer require grace-team-work/mixed_sdk`

#### 使用示例

```php
<?php
require_once './vendor/autoload.php';
use MixedSDK\SDKClient;

// 登录
$client = SDKClient::getInstance('chuxin');
$login = $client->login();
$login->setArgs(['uid' => '123456', 'pefix_ext' => []]);
$result = $login->checkLogin(['uid' => '123456', 'pefix_ext' => []]);


// 充值
$client = SDKClient::getInstance('chuxin');
$charge = $client->charge();
$charge->setArgs(['pay_ext' => '123456|aaa', 'amount' => 600]);
// 获取透传  订单号|服务器|包号
var_dump($charge->ext());
// 校验金额
var_dump($charge->checkMoney(6));
// 校验签名
var_dump($charge->checkSign());
```
