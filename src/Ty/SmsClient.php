<?php


namespace IotSpace\Ty;

use IotSpace\Support\HttpMethod;

/**
 * 短信服务
 * https://developer.tuya.com/cn/docs/cloud/7bb58f2438?id=Kaj5ld4h7v70h
 * @package IotSpace\Ty
 */
class SmsClient extends BaseClient
{
    /**
     * 添加短信模板
     * @param string $name 模板名称，长度为1~30 个字符
     * @param string $content 模板内容，长度为1~500 个字符
     * @param string $remark 短信模板申请说明，请在申请说明中描述您的业务使用场景，长度为 1~100个字符
     * @param int $type 短信类型，0：验证码，1：短信通知，2：推广短信
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function createTemplate(string $name, string $content, string $remark, int $type=0)
    {
        $url = "/v1.0/iot-03/msg-templates/sms";

        $body = [
            "name"=>$name,
            "content"=>$content,
            "remark"=>$remark,
            "type"=>$type
        ];

        $data = $this->getHttpRequest($url, HttpMethod::POST, true, $body);

        return $data;
    }

    /**
     * 查询短信模板详情
     * @param string $templateId
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getTemplate(string $templateId)
    {
        $url = "/v1.0/iot-03/msg-templates/sms/{$templateId}";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 获取短信模板列表
     * @param int $pageNo
     * @param int $pageSize
     * @param int $sort 排序字段（0：创建时间升序，1：创建时间降序，不传默认按创建时间降序）
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getTemplates(int $pageNo=1, int $pageSize=10, int $sort=1)
    {
        $url = "/v1.0/iot-03/msg-templates/sms?page_no={$pageNo}&page_size={$pageSize}&sort={$sort}";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 发送短信
     * @param string $phone 手机号
     * @param string $templateId 短信模板 ID，必须填写已审核通过的模板 ID
     * @param array|null $templateParams 短信模板变量对应的实际值
     * @param string $countryCode 2位数字国家码
     * @param string $signName 短信签名
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function pushSms(string $phone, string $templateId, array $templateParams=null, string $countryCode='86', string $signName='')
    {
        $url = "/v1.0/iot-03/messages/sms/actions/push";

        $msgData =[
            "country_code"=>$countryCode,
            "template_id"=>$templateId,
            "phone"=>$phone
        ];
        if($templateParams){
            $msgData['template_param'] = $templateParams;
        }
        if(!empty($signName)){
            $msgData['sign_name'] = $signName;
        }
        $body = $msgData;

        $data = $this->getHttpRequest($url, HttpMethod::POST, true, $body);

        return $data;
    }
}