<?php


namespace IotSpace\Ty;

use IotSpace\Support\HttpMethod;
use IotSpace\Support\ParingType;

/**
 * 配网管理
 * https://developer.tuya.com/cn/docs/cloud/paring-management?id=K95ztzyeyul2w
 * @package IotSpace\Ty
 */
class PairTokenClient extends BaseClient
{
    /**
     * @param string $uid 涂鸦用户ID
     * @param string $paringType 配网类型，支持 BLE、AP、EZ
     * @param string $timeZone 用户所在时区
     * @param string $homeId 家庭 ID，不填则为用户默认家庭
     * @param array $extension 扩展信息，配网类型是 BLE 时需传入设备 UUID
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function createParingToken(string $uid, string $paringType = ParingType::BLE, string $timeZone = 'Asia/Shanghai', string $homeId = '', array $extension = null)
    {
        $url = "/v1.0/device/paring/token";

        $paringData = [
            "paring_type" => $paringType,
            "uid" => $uid,
            "time_zone_id" => $timeZone
        ];
        if (!empty($homeId)) {
            $paringData['home_id'] = $homeId;
        }
        if ($extension) {
            $paringData['extension'] = $extension;
        }
        $body = json_encode($paringData, JSON_UNESCAPED_UNICODE);

        $data = $this->getHttpRequest($url, HttpMethod::POST, true, $body);

        return $data;
    }

    /**
     * 轮询配网结果
     * @param string $token
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getParingDevices(string $token)
    {
        $url = "/v1.0/device/paring/tokens/{$token}";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 开放网关允许子设备入网
     * @param string $deviceId
     * @param int $duration 网关发现时间  取值范围：0~3600 秒
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function enabledGatewaySubDiscovery(string $deviceId, int $duration = 100)
    {
        $url = "/v1.0/devices/{$deviceId}/enabled-sub-discovery?duration={$duration}";

        $data = $this->getHttpRequest($url, HttpMethod::PUT, true);

        return $data;
    }

    /**
     * @param string $deviceId 网关设备 ID
     * @param int $discoveryTime 网关发现子设备时间，精确到秒
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getGatewayParingSubDevices(string $deviceId, int $discoveryTime)
    {
        $url = "/v1.0/devices/{$deviceId}/list-sub?discovery_time={$discoveryTime}";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 获取网关下的子设备列表
     * @param string $deviceId
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getGatewaySubDevices(string $deviceId)
    {
        $url = "/v1.0/devices/{$deviceId}/sub-devices";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }
}