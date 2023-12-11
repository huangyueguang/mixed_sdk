<?php

namespace channels\chuxin;

use core\BaseModule;

class Module extends BaseModule
{
    // 登录
    public function login()
    {
        return (new Login());
    }

    // 充值
    public function charge()
    {
        return (new Charge());
    }
}
