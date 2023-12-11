<?php
require_once './vendor/autoload.php';
use MixedSDK\SDKClient;
$client = SDKClient::getInstance('chuxin');
$charge = $client->charge()->setArgs(['pay_ext' => '123456|aaa', 'amount' => 600]);
// 获取透传  订单号|服务器|包号
var_dump($charge->ext());
// 校验金额
var_dump($charge->checkMoney(6));
exit();