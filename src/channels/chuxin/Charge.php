<?php
namespace channels\chuxin;

use channels\BaseCharge;
use core\Common;

class Charge extends BaseCharge
{
    /**
     * 获取透传
     * @return array
     */
    public function ext()
    {
        $orderId = $server = $package = '';
        try {
            if (!empty($this->params['third_order_id'])) {
                $orderId = $this->params['third_order_id'];
            } else if (!empty($this->params['pay_ext'])) {
                list($orderId) = explode('|', $this->params['pay_ext']);
            }
            return [$orderId, $server, $package];
        } catch (\Exception $e) {
            return [$orderId, $server, $package];
        }
    }

    /**
     * 金额校验
     * @param $money
     * @return array
     */
    public function checkMoney($money)
    {
        try {
            if ($this->params['amount'] / 100 != intval($money)) {
                return ['status' => false, 'msg' => 'check_money_fail'];
            }
            return ['status' => true, 'msg' => 'success'];
        } catch (\Exception $e) {
            return ['status' => false, 'msg' => $e->getMessage() . $e->getLine()];
        }
    }

    /**
     * 签名校验
     * @return array
     */
    public function checkSign()
    {
        try {
            $headers = (new Common())->getHeader();
            $signData = file_get_contents("php://input");
            $mySignature = self::sha256Sign(
                $headers['secretId'],
                $this->params['game']['secretKey'],
                $headers['algorithm'],
                $headers['timestamp'],
                $signData
            );
            if ($headers['signature'] != $mySignature) {
                return ['status' => true, 'msg' => 'check_sign_fail'];
            }
            return ['status' => true, 'msg' => 'success'];
        } catch (\Exception $e) {
            return ['status' => false, 'msg' => $e->getMessage() . $e->getLine()];
        }
    }


    /**
     *  chuxin_sdk校验方法
     * @param $secretId
     * @param $secretKey
     * @param $algorithm
     * @param $timestamp
     * @param $data
     * @return string
     */
    protected static function sha256Sign($secretId, $secretKey, $algorithm, $timestamp, $data)
    {
        $signParams = $data . $secretId . $algorithm . $timestamp;
//        commonLogs('header_sign', date('Y-m-d H:i:s') . '---' . $signParams . PHP_EOL);
        //  计算HMAC的十六进制字符串值
        $signData = hash_hmac('sha256', $signParams, $secretKey);
//        commonLogs('header_sign', date('Y-m-d H:i:s') . '---' . $signData . PHP_EOL);
        return $signData;
    }

}
