<?php

namespace IotSpace\Ys;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use IotSpace\Exception\IotException;
use IotSpace\Exception\ErrorCode;
use IotSpace\Support\HttpMethod;

/**
 * 授权管理
 * https://open.ys7.com/doc/zh/book/index/user.html
 * @package IotSpace\Ys
 */
class TokenClient extends BaseClient
{
    /**
     * 获取令牌
     * @return string
     * @throws \IotSpace\Exception\IotException
     */
    public function getToken(): string
    {
        $url = '/api/lapp/token/get';

        if (Cache::has(self::CACHE_TOKEN_KEY)) {
            $token = Cache::get(self::CACHE_TOKEN_KEY);
            return $token;
        }

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
        $expireTime = $data['expireTime']; //Token过期时间  毫秒时间戳
        $this->accessToken = $accessToken;
        $expireDateTime = Carbon::createFromTimestampMs($expireTime);

        Cache::put(self::CACHE_TOKEN_KEY, $accessToken, $expireDateTime);

        return $accessToken;
    }

}
