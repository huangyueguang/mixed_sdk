<?php

namespace core;

use MixedSDK\SDKClient;

class BaseModule
{
    protected $client;

    public function __construct(SDKClient $client)
    {
        $this->client = $client;
    }

}