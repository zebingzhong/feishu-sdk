<?php

namespace Wwlh\FeishuSdk;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class FeiShuClient
{
    /**
     * @var array
     */
    protected array $headers;

    /**
     * @var array
     */
    protected array $params;

    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @throws GuzzleException
     */
    public function __construct()
    {
        $this->client = new Client(['verify' => config('feishu.verify')]);
    }

    /**
     * @param string $className
     * @return mixed
     * @throws GuzzleException
     */
    public function gateway(string $className)
    {
        $gateWayArr = [
            'department' => \Wwlh\FeishuSdk\Department\Department::class,
            'user'       => \Wwlh\FeishuSdk\User\User::class,
            'login'      => \Wwlh\FeishuSdk\Login\Login::class,
        ];
        return new $gateWayArr[$className]($this->client);
    }
}