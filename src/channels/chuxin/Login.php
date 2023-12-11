<?php
namespace channels\chuxin;

use channels\BaseLogin;
use Curl\Curl;

class Login extends BaseLogin
{
    /**
     * 设置sdk参数
     * @param mixed $args
     * @return $this
     */
    public function setArgs($args)
    {
        foreach ($args as $key => $value) {
            $this->params[$key] = $this->{$key} = $value;
        }
        return $this;
    }

    /**
     * 二次登录校验
     * @param mixed $args
     * @return array
     */
    public function checkLogin()
    {
        try {
            // 请求body
            $postData = [
                'data' => $this->params['pefix_ext']
            ];
            // 请求头
            $timestamp = time();
            $headerData = [
                'Content-Type:application/json',
                'secretId:' . $this->params['game']['secretId'],
                'algorithm:' . 'CX-HMAC-SHA256',
                'timestamp:' . $timestamp,
                'signature:' .  self::sha256Sign(
                    $this->params['game']['secretId'],
                    $this->params['game']['secretKey'],
                    'CX-HMAC-SHA256',
                    $timestamp,
                    json_encode($postData))
            ];
            $curl = new Curl();
            $curl->setHeaders($headerData);
            $curl->post($this->params['game']['node'] . '/v1/api/index', $postData);
            $resp = json_decode($curl->response->json, 1);
            if ($resp['code'] != 1000) {
                return ['status' => false, 'msg' => $curl->response->json];
            }
            $resp = array_merge(['uid' => $this->params['uid']], $resp['data']);
            return ['status' => true, 'msg' => 'success', 'data' => $resp];
        } catch (\Exception $e) {
            return ['status' => false, 'msg' => $e->getMessage() . $e->getLine()];
        }
    }

    protected static function sha256Sign($secretId, $secretKey, $algorithm, $timestamp, $data) {
        $signParams = $data . $secretId . $algorithm . $timestamp;
        //  计算HMAC的十六进制字符串值
        return hash_hmac('sha256', $signParams, $secretKey);
        //  计算HMAC的二进制字符串值
//        $hashed = hash_hmac('sha256', $signParams, $secretKey, true);
//        return bin2hex($hashed);
    }
}
