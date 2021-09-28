<?php


namespace IotSpace\Ty;

use IotSpace\Exception\IotException;
use IotSpace\Support\HttpMethod;

/**
 * 全屋智能设备管理
 * https://developer.tuya.com/cn/docs/cloud/smart-home-devices-management?id=Kainejcoo5nwr
 * @package IotSpace\Ty
 */
class DeviceClient extends BaseClient
{
    /**
     * 获取设备详情
     * https://developer.tuya.com/cn/docs/cloud/device-management?id=K9g6rfntdz78a#title-1-%E8%8E%B7%E5%8F%96%E8%AE%BE%E5%A4%87%E8%AF%A6%E6%83%85
     * @param string $deviceId
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getDevice(string $deviceId)
    {
        $url = "/v1.0/devices/{$deviceId}";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 获取设备列表
     * https://developer.tuya.com/cn/docs/cloud/device-management?id=K9g6rfntdz78a#title-19-%E8%8E%B7%E5%8F%96%E8%AE%BE%E5%A4%87%E5%88%97%E8%A1%A8
     * @param int $pageNo
     * @param int $pageSize
     * @param string $productId
     * @param string $deviceIds
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getDevices(int $pageNo=1, int $pageSize=10, string $productId='', string $deviceIds='')
    {
        $schema = $this->config['schema'];
        $url = "/v1.0/devices?schema={$schema}&product_id={$productId}&device_ids={$deviceIds}&page_no={$pageNo}&page_size={$pageSize}";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 获取用户下设备列表
     * https://developer.tuya.com/cn/docs/cloud/device-management?id=K9g6rfntdz78a#title-10-%E8%8E%B7%E5%8F%96%E7%94%A8%E6%88%B7%E4%B8%8B%E8%AE%BE%E5%A4%87%E5%88%97%E8%A1%A8
     * @param string $uid 涂鸦用户 ID
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getUserDevices(string $uid)
    {
        $url = "/v1.0/users/{$uid}/devices";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 根据设备 ID 来移除设备
     * @param string $deviceId
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function deleteDevice(string $deviceId)
    {
        $url = "/v1.0/devices/{$deviceId}";

        $data = $this->getHttpRequest($url, HttpMethod::DELETE, true);

        return $data;
    }

    /**
     * 查询设备关联的用户列表
     * @param string $deviceId
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getDeviceUsers(string $deviceId)
    {
        $url = "/v1.0/devices/{$deviceId}/users";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 获取指令集（按设备）
     * https://developer.tuya.com/cn/docs/cloud/device-control?id=K95zu01ksols7#title-9-%E8%8E%B7%E5%8F%96%E6%8C%87%E4%BB%A4%E9%9B%86%EF%BC%88%E6%8C%89%E8%AE%BE%E5%A4%87%EF%BC%89
     * @param string $deviceId
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getDeviceFunctions(string $deviceId)
    {
        $url = "/v1.0/devices/{$deviceId}/functions";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 批量获取指令集（按设备）
     * https://developer.tuya.com/cn/docs/cloud/device-control?id=K95zu01ksols7#title-18-%E6%89%B9%E9%87%8F%E8%8E%B7%E5%8F%96%E6%8C%87%E4%BB%A4%E9%9B%86%EF%BC%88%E6%8C%89%E8%AE%BE%E5%A4%87%EF%BC%89
     * @param string $deviceIds
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getDevicesFunctions(string $deviceIds)
    {
        $url = "/v1.0/devices/functions?device_ids={$deviceIds}";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 获取设备规格属性（包含指令集和状态集）
     * https://developer.tuya.com/cn/docs/cloud/device-control?id=K95zu01ksols7#title-27-%E8%8E%B7%E5%8F%96%E8%AE%BE%E5%A4%87%E8%A7%84%E6%A0%BC%E5%B1%9E%E6%80%A7%EF%BC%88%E5%8C%85%E5%90%AB%E6%8C%87%E4%BB%A4%E9%9B%86%E3%80%81%E7%8A%B6%E6%80%81%E9%9B%86%EF%BC%89
     * @param string $deviceId
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getDeviceSpecifications(string $deviceId)
    {
        $url = "/v1.0/devices/{$deviceId}/specifications";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 获取设备最新状态
     * https://developer.tuya.com/cn/docs/cloud/device-control?id=K95zu01ksols7#title-44-%E8%8E%B7%E5%8F%96%E8%AE%BE%E5%A4%87%E6%9C%80%E6%96%B0%E7%8A%B6%E6%80%81
     * @param string $deviceId
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getDeviceStatus(string $deviceId)
    {
        $url = "/v1.0/devices/{$deviceId}/status";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        if(!$data) {
            return [];
        }

        return array_column($data, 'value', 'code');
    }

    /**
     * 获取单个设备在线状态
     * @param string $deviceId
     * @return boolean
     * @throws IotException
     */
    public function getDeviceOnlineStatus(string $deviceId)
    {
        $data = $this->getDevice($deviceId);

        return (bool)$data['online'];
    }

    /**
     * 批量获取设备最新状态
     * @param string $deviceIds
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getDevicesStatus(string $deviceIds)
    {
        $url = "/v1.0/devices/status?device_ids={$deviceIds}";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);
        if(!$data) {
            return [];
        }

        return array_column($data, 'status', 'id');
    }

    /**
     * 下发设备指令
     * @param string $deviceId
     * @param array $commands
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function executeDeviceCommands(string $deviceId, array $commands)
    {
        $url = "/v1.0/devices/{$deviceId}/commands";

        if (count($commands) > 1) {
            $body['commands'] = $commands;
        } else {
            $body['commands'] = [$commands];
        }
        $data = $this->getHttpRequest($url, HttpMethod::POST, true, $body);

        return $data;
    }
}
