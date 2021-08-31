<?php

namespace IotSpace\Ys;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
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
    public function getEsToken(): string
    {
        if (Cache::has(self::ES_CACHE_TOKEN_KEY)) {
            $token = Cache::get(self::ES_CACHE_TOKEN_KEY);
            return $token;
        }

        $url = '/api/user/component-open/sso/oauth2/getEZAccessToken';

        $postData = [
            'accessToken' => $this->getCacheToken()
        ];

        $data = $this->getHttpRequest($url, $postData, HttpMethod::POST, false, true);

        $ezOpenAccessToken = $data['ezOpenAccessToken'];
        $expireTime = $data['expireTime']; //Token过期时间  毫秒时间戳

        $expireDateTime = Carbon::createFromTimestampMs($expireTime);

        Cache::put(self::ES_CACHE_TOKEN_KEY, $ezOpenAccessToken, $expireDateTime);

        return $ezOpenAccessToken;
    }

}
