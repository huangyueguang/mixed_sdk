<?php
namespace channels;


class BaseLogin
{
    protected $params = [
        'uid' => '',
        'pefix_ext' => ''
    ];

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
}
