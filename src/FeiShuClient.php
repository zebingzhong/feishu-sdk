<?php

namespace Wwlh\FeishuSdk;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class FeiShuClient
{
    /**
     * @var string
     */
    protected string $appAccessToken;

    /**
     * @var string
     */
    protected string $appAccessTokenUrl = 'https://open.feishu.cn/open-apis/auth/v3/app_access_token/internal';

    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @throws GuzzleException
     */
    public function __construct($config)
    {
        $this->client = new Client(['verify' => $config['verify']]);
        $this->appAccessToken = $this->appAccessToken($config['app_id'], $config['app_secret']);
    }

    /**
     * @param $appId
     * @param $appSecret
     * @return mixed
     * @throws GuzzleException
     */
    public function appAccessToken($appId, $appSecret)
    {
        $res = $this->client->post($this->appAccessTokenUrl, [
            'headers' => ['Content-Type' => 'application/json; charset=utf-8'],
            'query' => [
                "app_id" => $appId,
                "app_secret" => $appSecret
            ]
        ]);
        $response = json_decode($res->getBody()->getContents(), true);
        if ($response['code'] != 0) {
            throw new \Exception("授权失败，失败原因：" . $response['msg']);
        }
        return $response['app_access_token'];
    }
}