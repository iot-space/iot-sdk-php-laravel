<?php

namespace IotSpace\Ys;

use IotSpace\Exception\IotException;
/**
 * 设备管理
 * https://open.ys7.com/doc/zh/book/index/device.html
 * @package IotSpace\Ys
 */
class DeviceClient extends BaseClient
{
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

    /**
     * 获取获取播放地址
     * @param string $deviceSerial
     * @param int $type ezopen协议地址的类型，1-预览，2-本地录像回放，3-云存储录像回放，非必选，默认为1
     * @param int $protocol 流播放协议，1-ezopen、2-hls、3-rtmp、4-flv，默认为1
     * @param int $expireTime 过期时长，单位秒；针对hls/rtmp设置有效期，相对时间；30秒-720天，默认365天
     * @param int $quality 视频清晰度，1-高清（主码流）、2-流畅（子码流）
     * @param string $startTime ezopen协议地址的本地录像/云存储录像回放开始时间,示例：2019-12-01 00:00:00
     * @param string $stopTime ezopen协议地址的本地录像/云存储录像回放开始时间,示例：2019-12-01 00:00:00
     * @return bool|mixed
     * @throws IotException
     */
    public function getLiveAddress(string $deviceSerial, int $type=1, int $protocol=1, int $expireTime=31536000,int $quality=2, string $startTime='', string $stopTime='')
    {
        $url = "/api/lapp/v2/live/address/get";

        $postData = [
            "deviceSerial" => $deviceSerial,
            "type" => $type,
            "protocol" => $protocol,
            "expireTime" => $expireTime,
            "quality" => $quality
        ];
        if(!empty($startTime) && !empty($stopTime)){
            $postData['startTime']=$startTime;
            $postData['stopTime']=$stopTime;
        }

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 根据设备序列号查询设备能力集
     * @param string $deviceSerial
     * @return bool|mixed
     * @throws IotException
     */
    public function getDeviceCapacity(string $deviceSerial)
    {
        $url = "/api/lapp/device/capacity";

        $postData = [
            "deviceSerial" => $deviceSerial
        ];

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

}
