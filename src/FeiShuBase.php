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
     * @param $appId
     * @param $appSecret
     */
    public function __construct($client, $appAccessToken)
    {
        $this->client = $client;
        $this->headers = [
            'Authorization' => 'Bearer ' . $appAccessToken,
            'Content-Type' => 'application/json; charset=utf-8'
        ];
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
            throw new \Exception($response['msg']);
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
            throw new \Exception($response['msg']);
        }
        return $response;
    }
}
