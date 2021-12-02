<?php


namespace IotSpace\Ty;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use IotSpace\Support\ApiRequest;
use IotSpace\Exception\IotException;
use IotSpace\Exception\ErrorCode;
use IotSpace\Support\HttpMethod;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Cache;
use IotSpace\Support\Platform;

abstract class BaseClient
{
    const CACHE_TOKEN_KEY = 'TY_ACCESS_TOKEN';

    /**
     * @var Illuminate\Foundation\Application
     */
    protected $app;
    /**
     * @var array
     */
    protected $config;

    /**
     * 构造函数 自动注入 Laravel app实例
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct(\Illuminate\Foundation\Application $app)
    {
        $this->config = $app['config']->get('iot.ty');
    }

    protected function getCacheToken()
    {
        if (Cache::has(self::CACHE_TOKEN_KEY)) {
            return Cache::get(self::CACHE_TOKEN_KEY);
        } else {
            $token = app(TokenClient::class)->getToken();
            return $token;
        }
    }

    protected function getHeaders(string $url, string $method, $body = null, bool $withToken = true)
    {
        $nonce     = uniqid();
        $timestamp = getMicroTime();

        $clientId = $this->config['client_id'];
        $secret   = $this->config['secret'];
        if (empty($clientId)) {
            throw new IotException('缺少TY_CLIENT_ID配置', ErrorCode::OPTIONS);
        }
        if (empty($secret)) {
            throw new IotException('缺少TY_SECRET配置', ErrorCode::OPTIONS);
        }

        //新签名机制 2021年12月2日10:30:44  str = client_id + access_token + t + nonce + stringToSign
        $stringToSign = $this->getStringToSign($url, $method, $body);
        if ($withToken) {
            $data = $clientId . $this->getCacheToken() . $timestamp . $nonce . $stringToSign;
        } else {
            $data = $clientId . $timestamp . $nonce . $stringToSign;
        }
        $hash = hash_hmac("sha256", $data, $secret);
        $sign = strtoupper($hash);

        $headers = [
            'client_id'   => $clientId,
            'sign'        => $sign,
            't'           => $timestamp,
            'nonce'       => $nonce,
            'sign_method' => 'HMAC-SHA256'
        ];

        if ($withToken) {
            $headers['access_token'] = $this->getCacheToken();
            $headers['Content-Type'] = 'application/json';
        }
        return $headers;
    }

    /**
     * @param $url
     * @param string $method
     * @param bool $withToken
     * @param null $body
     * @return mixed
     * @throws IotException
     */
    protected function getHttpRequest($url, $method = HttpMethod::GET, bool $withToken = true, $body = null)
    {
        $headers = $this->getHeaders($url, $method, $body, $withToken);
        $url     = $this->config['api'] . $url;
        $options = [
            'headers' => $headers
        ];
        if ($body) {
            $options['body'] = json_encode($body, JSON_UNESCAPED_UNICODE);
        }
        $res = ApiRequest::httpRequest($method, $url, $options);
        DB::table('iot_log')->insert([
            'platform'   => Platform::TY,
            'method'     => $method,
            'url'        => $url,
            'res_code'   => $res['code'] ?? '',
            'res_data'   => var_export($res, true),
            'post_data'  => var_export($options, true),
            'message'    => $res['msg'] ?? '',
            'createtime' => date('Y-m-d H:i:s'),
        ]);
        if (!$res['success']) {
            throw new IotException($res['msg'], ErrorCode::TY, $res);
        }
        $res = $res['result'];
        return $res;
    }

    /***
     * 签名机制 -- 签名字符串
     * @param string $method
     * @param string $url
     * @param string $body
     * @return mixed
     */
    protected function getStringToSign(string $url, string $method, string $body = null)
    {
        $method = strtoupper($method);
        if (empty($body)) {
            $body = '';
        }
        $contentSha256 = hash("sha256", $body);
        $headersStr    = '';
        $signUrl       = $method . "\n" . $contentSha256 . "\n" . $headersStr . "\n" . $url;
        return $signUrl;
    }
}
