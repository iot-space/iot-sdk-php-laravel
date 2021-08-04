<?php

namespace IotSpace\Ys;

use IotSpace\Exception\IotException;
/**
 * 设备管理
 * https://open.ys7.com/saas/openapi/zh/base/device/explain.html
 * @package IotSpace\Ys
 */
class DeviceClient extends BaseClient
{
    /**
     * 添加设备
     * @param string $deviceSerial 设备序列号
     * @param string $validateCode 设备验证码
     * @return mixed
     * @throws IotException
     */
    public function addDevice(string $deviceSerial, string $validateCode)
    {
        $url = "/api/component/saas/res/device/add";

        $postData = [
            "deviceSerial"=>$deviceSerial,
            "validateCode"=>$validateCode
        ];

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 修改设备名称
     * @param string $deviceSerial
     * @param string $deviceName
     * @return mixed
     * @throws IotException
     */
    public function editDeviceName(string $deviceSerial, string $deviceName)
    {
        $url = "/api/component/saas/res/device/name/update";

        $postData = [
            "deviceSerial"=>$deviceSerial,
            "deviceName"=>$deviceName
        ];

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 删除设备
     * @param string $deviceSerial
     * @return mixed
     * @throws IotException
     */
    public function deleteDevice(string $deviceSerial)
    {
        $url = "/api/component/saas/res/device/delete";

        $postData = [
            "deviceSerial"=>$deviceSerial
        ];

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 设备分页查询
     * @param int $pageNo
     * @param int $pageSize
     * @param string $deviceSerial
     * @param string $deviceName
     * @return mixed
     * @throws IotException
     */
    public function getDevices(int $pageNo=1, int $pageSize=10, string $deviceSerial='', string $deviceName='')
    {
        $url = "/api/component/saas/res/device/list/page";

        $postData = [
            "pageNo"=>$pageNo,
            "pageSize"=>$pageSize
        ];
        if(!empty($deviceSerial)){
            $postData['deviceSerial'] = $deviceSerial;
        }
        if(!empty($deviceName)){
            $postData['deviceName'] = $deviceName;
        }

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 获取单个设备信息
     * @param string $deviceSerial
     * @return mixed
     * @throws IotException
     */
    public function getDevice(string $deviceSerial)
    {
        $url = "/api/lapp/device/info";

        $postData = [
            "deviceSerial" => $deviceSerial
        ];

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 获取设备状态信息
     * @param string $deviceSerial
     * @return mixed
     * @throws IotException
     */
    public function getDeviceStatus(string $deviceSerial)
    {
        $url = "/api/lapp/device/status/get";

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
     * 设备重启
     * 重启设备，目前仅支持门锁网关(CS-DL-GW3)的重启。
     * @param string $deviceSerial
     * @return mixed
     * @throws IotException
     */
    public function rebootDevice(string $deviceSerial)
    {
        $url = "/api/component/saas/res/device/reboot";

        $postData = [
            "deviceSerial" => $deviceSerial
        ];

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 设备初始化
     * 初始化设备，目前仅支持门锁网关(CS-DL-GW3)，初始化会解除智能网关与智能锁的配对状态
     * @param string $deviceSerial
     * @return mixed
     * @throws IotException
     */
    public function resetDevice(string $deviceSerial)
    {
        $url = "/api/component/saas/res/device/reset";

        $postData = [
            "deviceSerial" => $deviceSerial
        ];

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 获取设备版本信息
     * @param string $deviceSerial
     * @return mixed
     * @throws IotException
     */
    public function getDeviceVersion(string $deviceSerial)
    {
        $url = "/api/lapp/device/version/info";

        $postData = [
            "deviceSerial" => $deviceSerial
        ];

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 设备升级固件
     * @param string $deviceSerial
     * @return mixed
     * @throws IotException
     */
    public function upgradeDevice(string $deviceSerial)
    {
        $url = "/api/lapp/device/upgrade";

        $postData = [
            "deviceSerial" => $deviceSerial
        ];

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 获取设备升级状态
     * @param string $deviceSerial
     * @return mixed
     * @throws IotException
     */
    public function getUpgradeDeviceStatus(string $deviceSerial)
    {
        $url = "/api/lapp/device/upgrade/status";

        $postData = [
            "deviceSerial" => $deviceSerial
        ];

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

}
