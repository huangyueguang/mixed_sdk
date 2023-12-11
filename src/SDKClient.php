<?php
/**
 * Created by PhpStorm.
 * User: huangyueguang
 * Date: 2023/12/08
 */

namespace MixedSDK;


class SDKClient
{
    public static $channel;

    private static $instance = null;

    // 禁止被实例化
    private function __construct($channel){}

    // 禁止clone
    private function __clone(){}

    // 实例化自己并保存到$instance中，已实例化则直接调用
    public static function getInstance($channel)
    {
        static::$channel = $channel;
        if (empty(self::$instance)) {
            self::$instance = new self($channel);
        }
        $class = 'channels\\' . static::$channel . '\\Module';
        return (new $class(self::$instance));
    }
}
