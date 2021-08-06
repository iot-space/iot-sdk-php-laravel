<?php


namespace IotSpace\Ys;

use IotSpace\Support\ApiRequest;
use IotSpace\Exception\IotException;
use IotSpace\Exception\ErrorCode;
use IotSpace\Support\HttpMethod;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use IotSpace\Support\Platform;

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
            'Content-Type' => 'application/x-www-form-urlencoded',
//            'Content-Type' => 'application/json'
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
     * @throws IotException
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
        DB::table('iot_log')->insert([
            'platform'=>Platform::YS,
            'method'=>$method,
            'url'=>$url,
            'res_code'=>$res['code']??'',
            'res_data'=>var_export($res, true),
            'post_data'=>var_export($options, true),
            'message'=>$res['msg']??'',
            'createtime'=>date('Y-m-d H:i:s'),
        ]);
        if((int)$res['code'] !== 200){
            throw new IotException($res['msg'], ErrorCode::YS, $res);
        }
        return $res['data']??true;
    }
}
