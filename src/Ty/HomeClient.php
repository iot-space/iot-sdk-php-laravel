<?php


namespace IotSpace\Ty;

use IotSpace\Support\HttpMethod;

/**
 * 家庭管理
 * https://developer.tuya.com/cn/docs/cloud/smart-home?id=K95zu08mbwztc
 * @package IotSpace\Ty
 */
class HomeClient extends BaseClient
{
    /**
     * 创建家庭
     * @param string $uid 涂鸦用户
     * @param string $name
     * @param array $rooms
     * @return mixed
     */
    public function createHome(string $uid, string $name, string $geoName='', $lat=null, $lon=null, array $rooms = [])
    {
        $url = "/v1.0/home/create-home";

        $home = ['name'=>$name];
        if(!empty($geoName)){
            $home['geo_name'] = $geoName;
        }
        if(!empty($lat)){
            $home['lat'] = $lat;
        }
        if(!empty($lon)){
            $home['lon'] = $lon;
        }
        $body = json_encode([
            "uid" => $uid,
            "home" => $home,
            "rooms" => $rooms
        ]);

        $data = $this->getHttpRequest($url, HttpMethod::POST, true, $body);

        return $data;
    }

    /**
     * 修改家庭
     * @param int $homeId
     * @param array $home
     * @return mixed
     */
    public function editHome(int $homeId, array $home)
    {
        $url = "/v1.0/homes/{$homeId}";

        $body = json_encode($home);

        $data = $this->getHttpRequest($url, HttpMethod::PUT, true, $body);

        return $data;
    }

    /**
     * 删除家庭
     * @param int $homeId
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function deleteHome(int $homeId)
    {
        $url = "/v1.0/homes/{$homeId}";

        $data = $this->getHttpRequest($url, HttpMethod::DELETE, true);

        return $data;
    }

    /**
     * 获取家庭详情
     * @param int $homeId
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function getHome(int $homeId)
    {
        $url = "/v1.0/homes/{$homeId}";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 查询家庭下全部设备列表
     * @param int $homeId
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function getHomeDevices(int $homeId)
    {
        $url = "/v1.0/homes/{$homeId}/devices";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 查询家庭用户列表
     * @param int $homeId
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function getHomeMembers(int $homeId)
    {
        $url = "/v1.0/homes/{$homeId}/members";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 添加家庭用户
     * @param int $homeId
     * @param string $schema
     * @param string $name
     * @param string $mobile
     * @param bool $isAdmin
     * @param string $countryCode
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function createHomeMember(int $homeId, $schema, string $name, string $mobile, bool $isAdmin = false, string $countryCode='86')
    {
        $url = "/v1.0/homes/{$homeId}/members";

        $body = json_encode([
            "app_schema"=>$schema,
            "member"=>[
                "country_code"=>$countryCode,
                "member_account"=>$mobile,
                "admin"=>$isAdmin,
                "name"=>$name
            ]
        ], JSON_UNESCAPED_UNICODE);

        $data = $this->getHttpRequest($url, HttpMethod::GET, true, $body);

        return $data;
    }

    /**
     * 删除家庭成员
     * @param int $homeId
     * @param string $uid
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function deleteHomeMember(int $homeId, string $uid)
    {
        $url = "/v1.0/homes/{$homeId}/members/{$uid}";

        $data = $this->getHttpRequest($url, HttpMethod::DELETE, true);

        return $data;
    }

    /**
     * 设置家庭成员权限
     * @param int $homeId
     * @param string $uid
     * @param bool $isAdmin
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function setHomeMember(int $homeId, string $uid, bool $isAdmin)
    {
        $url = "/v1.0/homes/{$homeId}/members/{$uid}";
        $body = json_encode([
            "admin"=>$isAdmin
        ], JSON_UNESCAPED_UNICODE);

        $data = $this->getHttpRequest($url, HttpMethod::PUT, true, $body);

        return $data;
    }


}