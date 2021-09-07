<?php

namespace IotSpace\Ys;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use IotSpace\Exception\ErrorCode;
use IotSpace\Exception\IotException;
use IotSpace\Support\HttpMethod;

/**
 * 授权管理
 * https://www.yuque.com/u1400669/kb/gefpbg
 * @package IotSpace\Ys
 */
class EsTokenClient extends EsBaseClient
{
    /**
     * 获取令牌
     * @return string
     * @throws \IotSpace\Exception\IotException
     */
    public function getToken(): string
    {
        if (Cache::has(self::ES_CACHE_TOKEN_KEY)) {
            $token = Cache::get(self::ES_CACHE_TOKEN_KEY);
            return $token;
        }

        $url = '/api/user/open-app/auth/gettoken';

        $key = $this->config['key'];
        $secret = $this->config['secret'];
        if(empty($key)){
            throw new IotException('缺少YS_KEY配置', ErrorCode::OPTIONS);
        }

        if(empty($secret)){
            throw new IotException('缺少YS_SECRET配置', ErrorCode::OPTIONS);
        }

        $postData = [
            'appKey' => $key,
            'appSecret' => $secret
        ];

        $data = $this->getHttpRequest($url, $postData, HttpMethod::POST, false, true);

        $accessToken = $data['accessToken'];
        $expiresIn = $data['expiresIn']; //Token过期时间  毫秒时间戳

        $expireDateTime = Carbon::now()->addSeconds($expiresIn);

        Cache::put(self::ES_CACHE_TOKEN_KEY, $accessToken, $expireDateTime);

        return $accessToken;
    }

}
