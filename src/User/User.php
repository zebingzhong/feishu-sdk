<?php

namespace Wwlh\FeishuSdk\User;

use GuzzleHttp\Exception\GuzzleException;
use Wwlh\FeishuSdk\FeiShuBase;

class User extends FeiShuBase
{

    /**
     * 获取单个用户的信息Url
     * @var string
     */
    protected string $userDetailUrl = 'https://open.feishu.cn/open-apis/contact/v3/users';

    /**
     * 获取用户列表请求的Url
     * @var string
     */
    protected string $userListUrl = 'https://open.feishu.cn/open-apis/contact/v3/users/find_by_department';

    /**
     * 获取单个用户详情
     * @param string $userId
     * @param string $userIdType
     * @param string $departmentIdType
     * @return array
     * @throws GuzzleException
     */
    public function userDetail(string $userId, string $userIdType = 'open_id', string $departmentIdType = 'department_id'): array
    {
        $userDetailUrl = $this->userDetailUrl . '/' . $userId;
        $response = $this->get($userDetailUrl, $this->headers, [
                'user_id_type' => $userIdType,
                'department_id_type' => $departmentIdType
            ]
        );
        return $response['data']['items'] ?? [];
    }

    /**
     * 获取用户列表 根据部门获取
     * @param string $departmentId
     * @param string $userIdType
     * @param string $departmentIdType
     * @return array
     * @throws GuzzleException
     */
    public function userList(string $departmentId = '0', string $userIdType = 'open_id', string $departmentIdType = 'open_department_id'): array
    {
        $response = $this->get($this->userListUrl, $this->headers, [
                'user_id_type' => $userIdType,
                'department_id_type' => $departmentIdType,
                'department_id' => $departmentId
            ]
        );
        return $response['data']['items'] ?? [];
    }
}
