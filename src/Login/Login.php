<?php

namespace Wwlh\FeishuSdk\Login;

use GuzzleHttp\Exception\GuzzleException;
use Wwlh\FeishuSdk\FeiShuBase;

class Login extends FeiShuBase
{
    /**
     * @var string
     */
    protected string $accessTokenUrl = 'https://open.feishu.cn/open-apis/authen/v1/access_token';

    /**
     * get user login info
     * @param string $code
     * @param string $grantType
     * @return array|mixed
     * @throws GuzzleException
     */
    public function login(string $code, string $grantType)
    {
        $response = $this->post($this->accessTokenUrl, [
            'Content-Type' => 'application/json; charset=utf-8'
        ], [
                'grant_type' => $grantType,
                'code' => $code
            ]
        );
        return $response['data'] ?? [];
    }
}
