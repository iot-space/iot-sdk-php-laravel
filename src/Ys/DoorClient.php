<?php

namespace IotSpace\Ys;

use IotSpace\Exception\ClientException;

/**
 * 云门禁
 * https://open.ys7.com/saas/openapi/zh/cloudkey/
 * @package IotSpace\Ys
 */
class DoorClient extends BaseClient
{
    /**
     * 下发权限到门禁
     * @param int $personId
     * @param string $deviceSerial
     * @return mixed
     * @throws ClientException
     */
    public function addPerson(int $personId, string $deviceSerial)
    {
        $url = "/api/component/saas/acs/person/add";

        $postData = [
            "personId"=>$personId,
            "deviceSerial"=>$deviceSerial
        ];

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 从门禁删除权限
     * 支持删除指定设备上所有用户权限信息，支持删除指定用户在所有设备的权限信息
     * @param int $personId 用户ID(设备序列号和用户ID必填一个)
     * @param string $deviceSerial 设备序列号(设备序列号和用户ID必填一个)
     * @return mixed
     * @throws ClientException
     */
    public function deletePerson(int $personId, string $deviceSerial)
    {
        $url = "/api/component/saas/acs/person/delete";

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
     * @param int $pageNo
     * @param int $pageSize
     * @param string $deviceSerial
     * @param int $personId
     * @return mixed
     * @throws ClientException
     */
    public function getPersons(int $pageNo=1, int $pageSize=10, string $deviceSerial='', int $personId=0)
    {
        $url = "/api/component/saas/acs/authority/list/page";

        $postData = [
            "pageNo"=>$pageNo,
            "pageSize"=>$pageSize
        ];
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
     * 远程控门
     * @param string $deviceSerial 设备序列号
     * @param string $cmd 参考DoorCmd枚举常量值
     * @return mixed
     * @throws ClientException
     */
    public function remoteCmd(string $deviceSerial, string $cmd)
    {
        $url = "/api/component/saas/acs/remote/door";

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
     * @return mixed
     * @throws ClientException
     */
    public function getEvents(string $deviceSerial, string $startTime, string $endTime, int $pageNo=1, int $pageSize=10)
    {
        $url = "/api/component/saas/acs/person/event/list/page";

        $postData = [
            "deviceSerial" => $deviceSerial,
            "startTime" => $startTime,
            "endTime" => $endTime,
            "pageNo"=>$pageNo,
            "pageSize"=>$pageSize
        ];

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

}
