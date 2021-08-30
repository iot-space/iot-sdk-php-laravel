<?php

namespace IotSpace\Es;

use IotSpace\Exception\IotException;
/**
 * 设备管理
 * https://www.yuque.com/u1400669/kb/epwfhw
 * @package IotSpace\Ys
 */
class DeviceClient extends BaseClient
{
    /**
     * 查询设备详情
     * @param string $deviceSerial
     * @return mixed
     * @throws IotException
     */
    public function getDevice(string $deviceSerial)
    {
        $url = "/api/resource/device/searchDeviceInfo";

        $postData = [
            "deviceSerial" => $deviceSerial
        ];

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 获取单个设备在线状态
     * @param string $deviceSerial
     * @return boolean
     * @throws IotException
     */
    public function getDeviceOnlineStatus(string $deviceSerial)
    {
        $data = $this->getDevice($deviceSerial);

        return (bool)$data['status'];
    }

    /**
     * 设备添加
     * @param string $deviceSerial
     * @param string $validateCode
     * @return bool|mixed
     * @throws IotException
     */
    public function addDevice(string $deviceSerial, string $validateCode)
    {
        $url = "/api/resource/component/device/add";

        $postData = [
            "deviceSerial" => $deviceSerial,
            "validateCode" => $validateCode
        ];

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 设备删除
     * @param string $deviceSerial
     * @return bool|mixed
     * @throws IotException
     */
    public function removeDevice(string $deviceSerial)
    {
        $url = "/api/resource/component/device/remove";

        $postData = [
            "deviceSerial" => $deviceSerial
        ];

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

}
