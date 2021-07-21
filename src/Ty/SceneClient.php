<?php


namespace IotSpace\Ty;


use IotSpace\Support\HttpMethod;

/**
 * 场景自动化
 * https://developer.tuya.com/cn/docs/cloud/scene-and-automatic?id=K95zu0bsi8i8s
 * @package IotSpace\Ty
 */
class SceneClient extends BaseClient
{
    /**
     * 查询家庭的场景列表
     * @param int $homeId
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function getScenes(int $homeId)
    {
        $url = "/v1.0/homes/{$homeId}/scenes";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 触发执行场景
     * @param int $homeId
     * @param string $sceneId
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function executeScene(int $homeId, string $sceneId)
    {
        $url = "/v1.0/homes/{$homeId}/scenes/{$sceneId}/trigger";

        $data = $this->getHttpRequest($url, HttpMethod::POST, true);

        return $data;
    }

    /**
     * 删除场景
     * @param int $homeId
     * @param string $sceneId
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function deleteScene(int $homeId, string $sceneId)
    {
        $url = "/v1.0/homes/{$homeId}/scenes/{$sceneId}";

        $data = $this->getHttpRequest($url, HttpMethod::DELETE, true);

        return $data;
    }

    /**
     * 添加场景
     * @param int $homeId
     * @param string $name
     * @param string $background
     * @param array $actions 结构参考：https://developer.tuya.com/cn/docs/cloud/scene-and-automatic?id=K95zu0bsi8i8s#title-32-%E6%B7%BB%E5%8A%A0%E5%9C%BA%E6%99%AF
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function createScene(int $homeId, string $name, string $background, array $actions)
    {
        $url = "/v1.0/homes/{$homeId}/scenes";

        $body = json_encode([
            "name"=>$name,
            "background"=>$background,
            "actions"=>$actions
        ], JSON_UNESCAPED_UNICODE);


        $data = $this->getHttpRequest($url, HttpMethod::POST, true, $body);

        return $data;
    }

    /**
     * 修改场景
     * @param int $homeId
     * @param int $sceneId
     * @param string $name
     * @param string $background
     * @param array $actions
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function editScene(int $homeId, int $sceneId, string $name, string $background, array $actions)
    {
        $url = "/v1.0/homes/{$homeId}/scenes/{$sceneId}";

        $body = json_encode([
            "name"=>$name,
            "background"=>$background,
            "actions"=>$actions
        ], JSON_UNESCAPED_UNICODE);

        $data = $this->getHttpRequest($url, HttpMethod::PUT, true, $body);

        return $data;
    }

    /**
     * 查询家庭下支持场景的设备列表
     * @param int $homeId
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function getHomeDevices(int $homeId)
    {
        $url = "/v1.0/homes/{$homeId}/scene/devices";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 场景绑定
     * @param int $deviceId
     * @param int $sceneId
     * @param string $code
     * @param string $value
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function bindScene(int $deviceId, int $sceneId, string $code, string $value)
    {
        $url = "/v1.0/devices/{$deviceId}/scenes/{$sceneId}";

        $body = json_encode([
            "code"=>$code,
            "value"=>$value
        ], JSON_UNESCAPED_UNICODE);

        $data = $this->getHttpRequest($url, HttpMethod::POST, true, $body);

        return $data;
    }

    /**
     * 场景解绑
     * @param int $deviceId
     * @param int $sceneId
     * @param string $code
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function unbindScene(int $deviceId, int $sceneId, string $code)
    {
        $url = "/v1.0/devices/{$deviceId}/scenes/{$sceneId}";

        $body = json_encode([
            "code"=>$code
        ], JSON_UNESCAPED_UNICODE);

        $data = $this->getHttpRequest($url, HttpMethod::DELETE, true, $body);

        return $data;
    }

    /**
     * 查询设备已绑定的场景列表
     * @param int $deviceId
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function getDeviceScenes(int $deviceId)
    {
        $url = "/v1.0/devices/{$deviceId}/scenes";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 添加自动化
     * @param int $homeId 家庭 ID
     * @param string $name 自动化名称
     * @param string $background 背景图片
     * @param int $matchType 匹配类型 1：任意条件满足触发。2：全部条件满足触发。3：自定义条件触发，需设定相关逻辑运算参数condition_rule
     * @param array $actions 动作列表
     * @param array $conditions 条件列表
     * @param string|null $conditionRule 自定义条件规则，当匹配类型 match_type=3，该参数必填
     * @param array $preconditions 前置条件，优先级最高
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function createAutomation(int $homeId, string $name, string $background, int $matchType, array $actions, array $conditions,string $conditionRule=null, array $preconditions)
    {
        $url = "/v1.0/homes/{$homeId}/automations";

        $postData = [
            "name"=>$name,
            "background"=>$background,
            "match_type"=>$matchType,
            "actions"=>$actions,
            "conditions"=>$conditions
        ];
        if(!empty($conditionRule)){
            $postData['condition_rule'] = $conditionRule;
        }
        if(!empty($preconditions)){
            $postData['preconditions'] = $preconditions;
        }
        $body = json_encode($postData, JSON_UNESCAPED_UNICODE);

        $data = $this->getHttpRequest($url, HttpMethod::POST, true, $body);

        return $data;
    }

    /**
     * 修改自动化
     * @param int $homeId 家庭ID
     * @param string $automationId 自动化ID
     * @param string $name 自动化名称
     * @param string $background 背景图片
     * @param int $matchType 匹配类型 1：任意条件满足触发。2：全部条件满足触发。3：自定义条件触发，需设定相关逻辑运算参数condition_rule
     * @param array $actions 动作列表
     * @param array $conditions 条件列表
     * @param string|null $conditionRule 自定义条件规则，当匹配类型 match_type=3，该参数必填
     * @param array $preconditions 前置条件，优先级最高
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function editAutomation(int $homeId, string $automationId, string $name, string $background, int $matchType, array $actions, array $conditions,string $conditionRule=null, array $preconditions)
    {
        $url = "/v1.0/homes/{$homeId}/automations/{$automationId}";

        $postData = [
            "name"=>$name,
            "background"=>$background,
            "match_type"=>$matchType,
            "actions"=>$actions,
            "conditions"=>$conditions
        ];
        if(!empty($conditionRule)){
            $postData['condition_rule'] = $conditionRule;
        }
        if(!empty($preconditions)){
            $postData['preconditions'] = $preconditions;
        }
        $body = json_encode($postData, JSON_UNESCAPED_UNICODE);

        $data = $this->getHttpRequest($url, HttpMethod::PUT, true, $body);

        return $data;
    }

    /**
     * 删除自动化
     * @param int $homeId 家庭ID
     * @param string $automationId 自动化ID
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function deleteAutomation(int $homeId, string $automationId)
    {
        $url = "/v1.0/homes/{$homeId}/automations/{$automationId}";

        $data = $this->getHttpRequest($url, HttpMethod::DELETE, true);

        return $data;
    }

    /**
     * 查询自动化列表
     * @param int $homeId 家庭ID
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function getAutomations(int $homeId)
    {
        $url = "/v1.0/homes/{$homeId}/automations";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 查询单个自动化
     * @param int $homeId 家庭ID
     * @param string $automationId 自动化ID
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function getAutomation(int $homeId, string $automationId)
    {
        $url = "/v1.0/homes/{$homeId}/automations/{$automationId}";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 触发自动化外部条件
     * @param int $homeId 家庭ID
     * @param string $automationId 自动化ID
     * @param array $conditions 条件列表
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function executeAutomation(int $homeId, string $automationId, array $conditions)
    {
        $url = "/v1.0/homes/{$homeId}/automations/{$automationId}/conditions/trigger";
        $postData = [
            "conditions"=>$conditions
        ];
        $body = json_encode($postData, JSON_UNESCAPED_UNICODE);

        $data = $this->getHttpRequest($url, HttpMethod::POST, true, $body);

        return $data;
    }

    /**
     * 查询支持自动化场景的设备列表
     * @param int $homeId 用户家庭 ID
     * @param string|null $type 支持的类型： condition：条件类型 action：动作类型
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function getAutomationDevices(int $homeId, string $type=null)
    {
        $url = "/v1.0/homes/{$homeId}/automation/devices";
        if(!empty($type)){
            $url .= "?type={$type}";
        }

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 查询自动化场景支持的天气条件
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function getAutomationWeather()
    {
        $url = "/v1.0/homes/automation/weather/conditions";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 获取家庭支持的联动条件
     * @param int $homeId
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function getHomeEnableLinkageCodes(int $homeId)
    {
        $url = "/v1.0/homes/{$homeId}/enable-linkage/codes";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 获取设备支持的联动条件
     * @param string $deviceId 设备ID
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function getDeviceEnableLinkageCodes(string $deviceId)
    {
        $url = "/v1.0/devices/{$deviceId}/enable-linkage/codes";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 启用自动化
     * @param int $homeId 家庭ID
     * @param string $automationId 自动化ID
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function enableAutomation(int $homeId, string $automationId)
    {
        $url = "/v1.0/homes/{$homeId}/automations/{$automationId}/actions/enable";

        $data = $this->getHttpRequest($url, HttpMethod::PUT, true);

        return $data;
    }

    /**
     * 停用自动化
     * @param int $homeId 家庭ID
     * @param string $automationId 自动化ID
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function disableAutomation(int $homeId, string $automationId)
    {
        $url = "/v1.0/homes/{$homeId}/automations/{$automationId}/actions/disable";

        $data = $this->getHttpRequest($url, HttpMethod::PUT, true);

        return $data;
    }

}