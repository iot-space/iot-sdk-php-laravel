<?php

namespace IotSpace\Ys;

use IotSpace\Exception\IotException;

/**
 * 智能门禁
 * https://www.yuque.com/u1400669/kb/glgnse
 * @package IotSpace\Ys
 */
class EsDoorClient extends EsBaseClient
{
    /**
     * 用户权限下发到门禁
     * @param int $personId
     * @param string $deviceSerial
     * @return mixed
     * @throws IotException
     */
    public function addPerson(int $personId, string $deviceSerial)
    {
        $url = "/api/acs/authority/person/add";

        $postData = [
            "personId"=>$personId,
            "deviceSerial"=>$deviceSerial
        ];

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 从门禁删除用户权限
     * 支持删除指定设备上所有用户权限信息，支持删除指定用户在所有设备的权限信息
     * @param int $personId 用户ID(设备序列号和用户ID必填一个)
     * @param string $deviceSerial 设备序列号(设备序列号和用户ID必填一个)
     * @return mixed
     * @throws IotException
     */
    public function deletePerson(int $personId, string $deviceSerial)
    {
        $url = "/api/acs/authority/person/delete";

        $postData = [];
        if($personId>0){
            $postData['personId'] = $personId;
        }
        if(!empty($deviceSerial)){
            $postData['deviceSerial'] = $deviceSerial;
        }

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 门禁人员权限信息分页查询
     * @param string $deviceSerial
     * @param int $pageNo
     * @param int $pageSize
     * @param int $personId
     * @return bool|mixed
     * @throws IotException
     */
    public function getPersons(string $deviceSerial, int $pageNo, int $pageSize, int $personId=0)
    {
        $url = "/api/acs/authority/list/page";

        $postData = [
            "deviceSerial" => $deviceSerial,
            "pageNo"=>$pageNo,
            "pageSize"=>$pageSize
        ];
        if($personId>0){
            $postData['personId'] = $personId;
        }

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 远程控门
     * @param string $deviceSerial 设备序列号
     * @param string $cmd 参考DoorCmd枚举常量值
     * @return mixed
     * @throws IotException
     */
    public function remoteCmd(string $deviceSerial, string $cmd)
    {
        $url = "/api/acs/remote/control";

        $postData = [
            "deviceSerial" => $deviceSerial,
            "cmd" => $cmd
        ];

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 门禁事件分页查询
     * @param string $deviceSerial 设备序列号
     * @param string $startTime 开始时间 如：2021-08-08
     * @param string $endTime 结束时间 如：2021-10-08
     * @param int $pageNo
     * @param int $pageSize
     * @param string $eventType 消息类型:AccessControllerEvent-门禁事件消息,SmartLockEvent-智能锁事件消息
     * @param string $acsEventType 门禁事件类型
     * @return mixed
     * @throws IotException
     */
    public function getEvents(string $deviceSerial, string $startTime, string $endTime,
                              int $pageNo=1, int $pageSize=10, string $eventType = '', string $acsEventType = '')
    {
        $url = "/api/acs/event/list/page";

        $postData = [
            "deviceSerial" => $deviceSerial,
            "startTime" => $startTime,
            "endTime" => $endTime,
            "pageNo"=>$pageNo,
            "pageSize"=>$pageSize
        ];
        if(!empty($eventType)){
            $postData['eventType'] = $eventType;
        }
        if(!empty($eventType)){
            $postData['acsEventType'] = $acsEventType;
        }

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

}
