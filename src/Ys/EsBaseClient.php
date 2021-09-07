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

abstract class EsBaseClient extends BaseClient
{
    const ES_CACHE_TOKEN_KEY = 'ES_ACCESS_TOKEN';

    protected function getHeaders()
    {
        $headers = [
            'Content-Type' => 'application/json'
        ];

        return $headers;
    }

    protected function getCacheToken()
    {
        if(Cache::has(self::ES_CACHE_TOKEN_KEY)){
            return Cache::get(self::ES_CACHE_TOKEN_KEY);
        }else{
            $token = app(EsTokenClient::class)->getToken();
            return $token;
        }
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
        $url = $this->config['es_api'].$url;
        $options = [];
        if($withHeaders){
            $options['headers'] = $this->getHeaders();
        }
        if($withToken){
            $postData['accessToken'] = $this->getCacheToken();
        }
        if($postData){
            $options['body'] = json_encode($postData, JSON_UNESCAPED_UNICODE);
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
