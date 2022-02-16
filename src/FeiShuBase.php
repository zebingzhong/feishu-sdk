<?php

namespace Wwlh\FeishuSdk;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

abstract class FeiShuBase
{
    /**
     * @var string
     */
    protected string $appAccessToken;

    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @var array
     */
    protected array $headers;

    /**
     * @var string
     */
    protected string $appAccessTokenUrl = 'https://open.feishu.cn/open-apis/auth/v3/app_access_token/internal';

    /**
     * @param $appId
     * @param $appSecret
     */
    public function __construct($client)
    {
        $this->appAccessToken = $this->appAccessToken();
        $this->client = $client;
        $this->headers = [
            'Authorization' => 'Bearer ' . $this->appAccessToken,
            'Content-Type' => 'application/json; charset=utf-8'
        ];
    }

    /**
     * @return mixed
     * @throws GuzzleException
     */
    public function appAccessToken()
    {
        $headers  = ['Content-Type' => 'application/json; charset=utf-8'];
        $params   = [
            "app_id"     => config('feishu.app_id'),
            "app_secret" => config('feishu.app_secret')
        ];
        $res      = $this->post($this->appAccessTokenUrl, $headers, $params);
        $response = json_decode($res->getBody()->getContents(), true);
        if ($response['code'] != 0) {
            throw new \Exception("授权失败，失败原因：" . $response['msg']);
        }
        return $response['app_access_token'];
    }

    /**
     * feishu get request
     * @param string $url
     * @param array $headers
     * @param array $params
     * @return array|mixed
     * @throws GuzzleException
     * @throws Exception
     */
    public function get(string $url, array $headers, array $params)
    {
        $res = $this->client->get($url, [
            'headers' => $headers,
            'query' => $params
        ]);
        $response = json_decode($res->getBody()->getContents(), true);
        if ($response['code'] != 0) {
            throw new Exception($response['msg']);
        }
        return $response;
    }

    /**
     * feishu post
     * @param string $url
     * @param array $headers
     * @param array $params
     * @return array|mixed
     * @throws GuzzleException
     * @throws Exception
     */
    public function post(string $url, array $headers, array $params)
    {
        $res = $this->client->post($url, [
            'headers' => $headers,
            'query' => $params
        ]);
        $response = json_decode($res->getBody()->getContents(), true);
        if ($response['code'] != 0) {
            throw new Exception($response['msg']);
        }
        return $response;
    }
}
