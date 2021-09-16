<?php


namespace IotSpace\Ty;

use Illuminate\Support\Facades\DB;
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
        if(Cache::has(self::CACHE_TOKEN_KEY)){
            return Cache::get(self::CACHE_TOKEN_KEY);
        }else{
            $token = app(TokenClient::class)->getToken();
            return $token;
        }
    }

    protected function getHeaders(bool $withToken = true)
    {
        $timestamp = getMicroTime();

        $clientId = $this->config['client_id'];
        $secret = $this->config['secret'];
        if(empty($clientId)){
            throw new IotException('缺少TY_CLIENT_ID配置', ErrorCode::OPTIONS);
        }
        if(empty($secret)){
            throw new IotException('缺少TY_SECRET配置', ErrorCode::OPTIONS);
        }

        if($withToken){
            $data = $clientId . $this->getCacheToken() . $timestamp;
        }else{
            $data = $clientId . $timestamp;
        }

        $hash = hash_hmac("sha256", $data, $secret);
        $sign = strtoupper($hash);

        $headers = [
            'client_id' => $clientId,
            'sign' => $sign,
            't' => $timestamp,
            'sign_method' => 'HMAC-SHA256'
        ];

        if($withToken){
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
        $url = $this->config['api'].$url;
        $headers = $this->getHeaders($withToken);
        $options = [
            'headers' => $headers
        ];
        if($body){
            $options['body'] = json_encode($body, JSON_UNESCAPED_UNICODE);
        }
        $res = ApiRequest::httpRequest($method, $url, $options);
        DB::table('iot_log')->insert([
            'platform'=>Platform::TY,
            'method'=>$method,
            'url'=>$url,
            'res_code'=>$res['code']??'',
            'res_data'=>var_export($res, true),
            'post_data'=>var_export($options, true),
            'message'=>$res['msg']??'',
            'createtime'=>date('Y-m-d H:i:s'),
        ]);
        if(!$res['success']){
            throw new IotException($res['msg'], ErrorCode::TY, $res);
        }
        $res = $res['result'];
        return $res;
    }
}
