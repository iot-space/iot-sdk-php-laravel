<?php


namespace IotSpace\Ty;

use IotSpace\Support\HttpMethod;

/**
 * 定时管理
 * https://developer.tuya.com/cn/docs/cloud/timing-management?id=K95zu050h5m53
 * @package IotSpace\Ty
 */
class TimeClient extends BaseClient
{
    /**
     * 设备添加定时任务
     * @param string $deviceId 设备ID
     * @param string $category 定时分类
     * @param string $loops 请求失败返由 0 和 1 组成的七位数字，0 代表关闭，1 代表开启。例如0000010代表周日，周一，周⼆，周三，周四，周五定时任务关闭，周六定时任务开启
     * @param array $instruct 定时任务具体的时间和设备指令，⽀持同时设置多个定时任务
     * @param string $aliasName 别名
     * @param string $timeZone 时区，中国区传 +08:00
     * @param string $timeZoneId 时区 ID，比如 Asia/shanghai
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function createTimer(string $deviceId, string $category, string $loops, array $instruct, string $aliasName, string $timeZone='+08:00', string $timeZoneId='Asia/shanghai')
    {
        $url = "/v1.0/devices/{$deviceId}/timers";

        $postData = [
            "category" => $category,
            "loops" => $loops,
            "time_zone" => $timeZone,
            "timezone_id" => $timeZoneId,
            "instruct" => $instruct
        ];
        if(!empty($aliasName)){
            $postData['alias_name'] = $aliasName;
        }

        $body = json_encode($postData, JSON_UNESCAPED_UNICODE);

        $data = $this->getHttpRequest($url, HttpMethod::POST, true, $body);

        return $data;
    }

    /**
     * 更新设备的某⼀个定时任务组的信息
     * @param string $deviceId 设备ID
     * @param string $groupId 定时任务组 ID
     * @param string $category 定时分类
     * @param string $loops 请求失败返由 0 和 1 组成的七位数字，0 代表关闭，1 代表开启。例如0000010代表周日，周一，周⼆，周三，周四，周五定时任务关闭，周六定时任务开启
     * @param array $instruct 定时任务具体的时间和设备指令，⽀持同时设置多个定时任务
     * @param string $aliasName 别名
     * @param string $timeZone 时区，中国区传 +08:00
     * @param string $timeZoneId 时区 ID，比如 Asia/shanghai
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function editTimer(string $deviceId, string $groupId, string $category, string $loops, array $instruct, string $aliasName, string $timeZone='+08:00', string $timeZoneId='Asia/shanghai')
    {
        $url = "/v1.0/devices/{$deviceId}/timers/groups/{$groupId}";

        $postData = [
            "category" => $category,
            "loops" => $loops,
            "time_zone" => $timeZone,
            "timezone_id" => $timeZoneId,
            "instruct" => $instruct
        ];
        if(!empty($aliasName)){
            $postData['alias_name'] = $aliasName;
        }

        $body = json_encode($postData, JSON_UNESCAPED_UNICODE);

        $data = $this->getHttpRequest($url, HttpMethod::PUT, true, $body);

        return $data;
    }

    /**
     * 更新设备定时任务组的状态
     * @param string $deviceId 设备ID
     * @param string $groupId 定时任务组 ID
     * @param string $category 定时分类
     * @param string $status 定时任务状态 0：关闭 1：开启 2：删除
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function setTimerStatus(string $deviceId, string $groupId, string $category, string $status)
    {
        $url = "/v1.0/devices/{$deviceId}/timers/categories/{$category}/groups/{$groupId}/status";

        $postData = [
            "value" => $status
        ];

        $body = json_encode($postData, JSON_UNESCAPED_UNICODE);

        $data = $this->getHttpRequest($url, HttpMethod::PUT, true, $body);

        return $data;
    }

    /**
     * 查询设备下的定时任务列表
     * @param string $deviceId
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getDeviceTimers(string $deviceId)
    {
        $url = "/v1.0/devices/{$deviceId}/timers";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 获取设备某一个分类下⾯的定时任务信息
     * @param string $deviceId
     * @param string $category
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getDeviceCategoryTimers(string $deviceId, string $category)
    {
        $url = "/v1.0/devices/{$deviceId}/timers/categories/{$category}";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 删除设备下的所有定时任务
     * @param string $deviceId
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function deleteDeviceTimers(string $deviceId)
    {
        $url = "/v1.0/devices/{$deviceId}/timers";

        $data = $this->getHttpRequest($url, HttpMethod::DELETE, true);

        return $data;
    }

    /**
     * 删除某个分类的定时任务
     * @param string $deviceId
     * @param string $category
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function deleteDeviceCategoryTimers(string $deviceId, string $category)
    {
        $url = "/v1.0/devices/{$deviceId}/timers/categories/{$category}";

        $data = $this->getHttpRequest($url, HttpMethod::DELETE, true);

        return $data;
    }

    /**
     * 删除某个分类下⾯的某个定时组的定时任务
     * @param string $deviceId
     * @param string $category
     * @param string $groupId
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function deleteDeviceCategoryGroupTimers(string $deviceId, string $category, string $groupId)
    {
        $url = "/v1.0/devices/{$deviceId}/timers/categories/{$category}/groups/{$groupId}";

        $data = $this->getHttpRequest($url, HttpMethod::DELETE, true);

        return $data;
    }


}