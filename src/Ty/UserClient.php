<?php


namespace IotSpace\Ty;

use IotSpace\Support\HttpMethod;

/**
 * 用户管理
 * https://developer.tuya.com/cn/docs/cloud/user-management?id=K95ztzvgwnshy
 * @package IotSpace\Ty
 */
class UserClient extends BaseClient
{
    /**
     * 同步用户
     * @param string $schema
     * @param string $userName
     * @param string $password 用户密码，如需在涂鸦 OEM App 中直接使用，OEM App 当前仅支持手机号和邮箱地址，且密码 hash 规则为 MD5 算法
     * @param int $type 用户名类型。 1：手机号 2：邮箱号 3：其他 默认值：3。
     * @param string $nickName
     * @param string $countryCode
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function saveUser(string $schema, string $userName, string $password, int $type, string $nickName='', string $countryCode='86')
    {
        $url = "/v1.0/apps/{$schema}/user";

        $body = json_encode([
            "country_code"=>$countryCode,
            "username"=>$userName,
            "password"=>$password,
            "username_type"=>$type,
            "nick_name"=>$nickName
        ]);

        $data = $this->getHttpRequest($url, HttpMethod::POST, true, $body);

        return $data;
    }

    /**
     * 获取用户列表
     * @param string $schema
     * @param int $pageNo
     * @param int $pageSize
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function getUsers(string $schema, int $pageNo=1, int $pageSize=10)
    {
        $url = "/v2.0/apps/{$schema}/users?page_no={$pageNo}&page_size={$pageSize}";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 获取用户信息
     * @param string $uid
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function getUserInfo(string $uid)
    {
        $url = "/v1.0/users/{$uid}/infos";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }


}