<?php


namespace IotSpace\Ys;

use IotSpace\Support\ApiRequest;
use IotSpace\Exception\ClientException;
use IotSpace\Exception\ErrorCode;
use IotSpace\Support\HttpMethod;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Cache;

abstract class BaseClient
{
    const CACHE_TOKEN_KEY = 'YS_ACCESS_TOKEN';

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
        $this->config = $app['config']->get('iot.ys');
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

    protected function getHeaders()
    {
        $headers = [
            'Host' => 'open.ys7.com',
//            'Content-Type' => 'application/x-www-form-urlencoded',
            'Content-Type' => 'application/json'
        ];

        return $headers;

    }

    /**
     * @param $url
     * @param array $postData
     * @param string $method
     * @param bool $withToken
     * @param bool $withHeaders
     * @return mixed
     * @throws ClientException
     */
    protected function getHttpRequest($url, array $postData, $method = HttpMethod::POST, bool $withToken=true, bool $withHeaders=true)
    {
        $url = $this->config['api'].$url;
        $options = [];
        if($withHeaders){
            $options['headers'] = $this->getHeaders();
        }
        if($withToken){
            $postData['accessToken'] = $this->getCacheToken();
        }
        if($postData){
            $options['form_params'] = $postData;
        }
        $res = ApiRequest::httpRequest($method, $url, $options);
        if((int)$res['code'] !== 200){
            $errorCode = $res['data']['errorCode'];
            throw new ClientException($errorCode, ErrorCode::DATA);
        }
        $res = $res['data'];
        return $res;
    }
}
