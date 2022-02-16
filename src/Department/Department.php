<?php

namespace Wwlh\FeishuSdk\Department;


use GuzzleHttp\Exception\GuzzleException;
use Wwlh\FeishuSdk\FeiShuBase;

class Department extends FeiShuBase
{
    /**
     * 获取单个部门详细信息Url
     * @var string
     */
    protected string $departmentDetailUrl = 'https://open.feishu.cn/open-apis/contact/v3/departments';

    /**
     * 获取子部门列表
     * @var string
     */
    protected string $departmentListUrl = 'https://open.feishu.cn/open-apis/contact/v3/departments';

    /**
     * 获取单个部门详细信息
     * @param string $departmentId
     * @param string $userIdType
     * @param string $departmentIdType
     * @return array
     * @throws GuzzleException
     */
    public function departmentDetail(string $departmentId, string $userIdType = 'open_id', string $departmentIdType = 'department_id'): array
    {
        $departmentDetailUrl = $this->departmentDetailUrl . '/' . $departmentId;
        $response            = $this->get($departmentDetailUrl, $this->headers, [
                'user_id_type'       => $userIdType,
                'department_id_type' => $departmentIdType,
            ]
        );
        return $response['data']['items'] ?? [];
    }

    /**
     * 获取部门列表信息- 通过获取子部门列表递归所有部门
     * @param string $departmentId
     * @param string $userIdType
     * @param string $departmentIdType
     * @param bool $fetchChild
     * @return array
     * @throws GuzzleException
     */
    public function departmentList(string $departmentId = '0', string $userIdType = 'open_id', string $departmentIdType = 'open_department_id', bool $fetchChild = true): array
    {
        $departmentListUrl = $this->departmentListUrl . '/' . $departmentId . '/children';
        $response          = $this->get($departmentListUrl, $this->headers, [
                'user_id_type'       => $userIdType,
                'department_id_type' => $departmentIdType,
                'fetch_child'        => $fetchChild,
            ]
        );
        return $response['data']['items'] ?? [];
    }
}
