<?php

namespace IotSpace\Ys;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use IotSpace\Exception\ClientException;
use IotSpace\Exception\ErrorCode;
use IotSpace\Support\HttpMethod;

/**
 * 人员信息管理
 * https://open.ys7.com/saas/openapi/zh/base/person/person_explain.html
 * https://www.yuque.com/u1400669/kb/ngah3g
 * @package IotSpace\Ys
 */
class UserClient extends BaseClient
{
    /**
     * 添加人员
     * @param string $personName 姓名
     * @param string $phoneNumber 手机号
     * @param string $validateType 校验类型:1-手机号证件号重复性,2-工号重复性,3-人脸重复性,4-图片格式+大小+眼间距,多个以“,”分割,默认校验所有类型
     * @param array|null $extension
     * @param array|null $cards
     * @param string $faceImageUrl
     * @param string $base64FaceImageFile
     * @param string $isUnique 是否校验手机号/证件号/工号唯一性:1或true-校验,0或false-不校验,默认校验
     * @param string $isValidateFace 是否校验人脸相似度,1或true-校验,0或false-不校验,默认校验
     * @param string $validateFaceType 人脸检测类型:1-人脸重复性+图片格式+大小+眼间距,2-人脸重复性,3-图片格式+大小+眼间距,默认1
     * @param string $label
     * @param string $remarks
     * @return mixed
     * @throws ClientException
     */
    public function addUser(string $personName, string $phoneNumber, string $validateType='',
                            array $extension=null, array $cards=null,
                            string $faceImageUrl='', string $base64FaceImageFile='',
                            string $isUnique = '1', string $isValidateFace = '1', string $validateFaceType='1',
                            string $label='',string $remarks='')
    {
        $url = "/api/person/add";

        $postData = [
            "personName"=>$personName,
            "phoneNumber"=>$phoneNumber,
            "isUnique"=>$isUnique,
            "isValidateFace"=>$isValidateFace,
            "validateFaceType"=>$validateFaceType
        ];
        if(!empty($validateType)){
            $postData['validateType'] = $validateType;
        }
        if(!empty($faceImageUrl)){
            $postData['faceImageUrl'] = $faceImageUrl;
        }
        if(!empty($base64FaceImageFile)){
            $postData['base64FaceImageFile'] = $base64FaceImageFile;
        }
        if(!empty($label)){
            $postData['label'] = $label;
        }
        if(!empty($remarks)){
            $postData['remarks'] = $remarks;
        }

        if(!empty($extension)){
            $postData['extension'] = $extension;
        }
        if(!empty($cards)){
            $postData['cards'] = $cards;
        }

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 修改人员
     * @param int $id 人员ID
     * @param string $personName 姓名
     * @param string $phoneNumber 手机号
     * @param string $validateType 校验类型:1-手机号证件号重复性,2-工号重复性,3-人脸重复性,4-图片格式+大小+眼间距,多个以“,”分割,默认校验所有类型
     * @param array|null $extension
     * @param array|null $cards
     * @param string $faceImageUrl
     * @param string $base64FaceImageFile
     * @param string $isUnique 是否校验手机号/证件号/工号唯一性:1或true-校验,0或false-不校验,默认校验
     * @param string $isValidateFace 是否校验人脸相似度,1或true-校验,0或false-不校验,默认校验
     * @param string $validateFaceType 人脸检测类型:1-人脸重复性+图片格式+大小+眼间距,2-人脸重复性,3-图片格式+大小+眼间距,默认1
     * @param string $label
     * @param string $remarks
     * @return mixed
     * @throws ClientException
     */
    public function editUser(int $id, string $personName='', string $phoneNumber='', string $validateType='',
                             array $extension=null, array $cards=null,
                             string $faceImageUrl='', string $base64FaceImageFile='',
                             string $isUnique = '1', string $isValidateFace = '1', string $validateFaceType='1',
                             string $label='',string $remarks='')
    {
        $url = "/api/person/add";

        $postData = [
            "id"=>$id,
            "isUnique"=>$isUnique,
            "isValidateFace"=>$isValidateFace,
            "validateFaceType"=>$validateFaceType
        ];
        if(!empty($personName)){
            $postData['personName'] = $personName;
        }
        if(!empty($phoneNumber)){
            $postData['phoneNumber'] = $phoneNumber;
        }
        if(!empty($validateType)){
            $postData['validateType'] = $validateType;
        }
        if(!empty($faceImageUrl)){
            $postData['faceImageUrl'] = $faceImageUrl;
        }
        if(!empty($base64FaceImageFile)){
            $postData['base64FaceImageFile'] = $base64FaceImageFile;
        }
        if(!empty($label)){
            $postData['label'] = $label;
        }
        if(!empty($remarks)){
            $postData['remarks'] = $remarks;
        }

        if(!empty($extension)){
            $postData['extension'] = $extension;
        }
        if(!empty($cards)){
            $postData['cards'] = $cards;
        }

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 删除人员
     * @param string $ids 人员ID列表（多个以,隔开）
     * @return mixed
     * @throws ClientException
     */
    public function deleteUser(string $ids)
    {
        $url = "/api/person/delete";

        $postData = [
            "ids"=>$ids,
        ];

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 获取人员列表
     * @param int $pageNo
     * @param int $pageSize
     * @param int $id 人员ID
     * @param string $personName
     * @param string $phoneNumber
     * @return mixed
     * @throws ClientException
     */
    public function getUsers(int $pageNo=1, int $pageSize=10, int $id=0, string $personName='', string $phoneNumber='')
    {
        $url = "/api/person/list/page";

        $postData = [
            "pageNo"=>$pageNo,
            "pageSize"=>$pageSize
        ];
        if($id>0){
            $postData['id'] = $id;
        }
        if(!empty($personName)){
            $postData['personName'] = $personName;
        }
        if(!empty($phoneNumber)){
            $postData['phoneNumber'] = $phoneNumber;
        }

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

    /**
     * 获取人员详情
     * @param int $id 人员ID
     * @return mixed
     * @throws ClientException
     */
    public function getUser(int $id)
    {
        $url = "/api/person/info";

        $postData = [
            "id"=>$id
        ];

        $data = $this->getHttpRequest($url, $postData);

        return $data;
    }

}
