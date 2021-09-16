<?php


namespace IotSpace\Ty;

use IotSpace\Support\HttpMethod;

/**
 * 行业通用用户管理
 * https://developer.tuya.com/cn/docs/cloud/industrial-general-user-management?id=Kaiuyafw5nrku
 * @package IotSpace\Ty
 */
class UserClient extends BaseClient
{
    /**
     * 注册用户
     * @param string $username
     * @param string $password 密码，一般建议用 SHA256 对密码加密然后转小写
     * @param string $countryCode
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function createUser(string $username, string $password, string $countryCode='86')
    {
        $url = "/v1.0/iot-02/users";

        $body = [
            "country_code"=>$countryCode,
            "username"=>$username,
            "password"=>$password
        ];

        $data = $this->getHttpRequest($url, HttpMethod::POST, true, $body);

        return $data;
    }

    /**
     * 分页查询用户列表
     * @param int $pageSize
     * @param string $lastRowKey 每页最后一条数据行号
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getUsers(int $pageSize=10, string $lastRowKey='')
    {
        $url = "/v1.0/iot-02/users?last_row_key={$lastRowKey}&page_size={$pageSize}";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 修改用户密码
     * @param string $uid
     * @param string $oldPassword 老的密码，一般建议用 SHA256 对密码加密然后转小写
     * @param string $newPassword 新的密码，一般建议用 SHA256 对密码加密然后转小写
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function updateUserPassword(string $uid, string $oldPassword, string $newPassword)
    {
        $url = "/v1.0/iot-02/users/{$uid}";

        $body = [
            "user_id"=>$uid,
            "old_password"=>$oldPassword,
            "new_password"=>$newPassword
        ];

        $data = $this->getHttpRequest($url, HttpMethod::PUT, true, $body);

        return $data;
    }

    /**
     * 重置用户密码
     * @param string $username
     * @param string $newPassword 新密码，一般建议用 SHA256 对密码加密然后转小写
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function resetUserPassword(string $username, string $newPassword)
    {
        $url = "/v1.0/iot-02/users/reset-password";

        $body = [
            "username"=>$username,
            "new_password"=>$newPassword
        ];

        $data = $this->getHttpRequest($url, HttpMethod::PUT, true, $body);

        return $data;
    }

    /**
     * 修改用户基本信息
     * @param string $uid
     * @param string $username
     * @param string $nickname
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function updateUser(string $uid, string $username='', string $nickname='')
    {
        $url = "/v1.0/iot-02/users/{$uid}";

        $body = [];
        if(!empty($username)){
            $body['user_name'] = $username;
        }
        if(!empty($nickname)){
            $body['user_nick_name'] = $nickname;
        }

        $data = $this->getHttpRequest($url, HttpMethod::PUT, true, $body);

        return $data;
    }

    /**
     * 删除用户
     * @param string $uid
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function deleteUser(string $uid)
    {
        $url = "/v1.0/iot-02/users/{$uid}";

        $data = $this->getHttpRequest($url, HttpMethod::DELETE, true);

        return $data;
    }

    /**
     * 删除用户
     * @param string $uid
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getUser(string $uid)
    {
        $url = "/v1.0/iot-02/users/{$uid}";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }


}
