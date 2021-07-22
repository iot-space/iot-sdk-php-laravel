<?php

namespace IotSpace\Support;

use GuzzleHttp\Client;
use IotSpace\Exception\IotException;
use IotSpace\Exception\ErrorCode;

class ApiRequest
{
    /**
     * @var Client
     */
    private static $httpClient;

    private function __construct()
    {

    }

    public static function httpRequest($method, $url, $options){
        if(!self::$httpClient) {
            self::$httpClient = new Client();
        }
        try {
            $res = self::$httpClient->request($method, $url, $options);
            $res = $res->getBody()->getContents();
            $res = json_decode($res, true);
            return $res;
        } catch (\Exception $ex) {
            throw new IotException($ex->getMessage(), ErrorCode::HTTP, null, $ex);
        }
        return false;
    }

}
