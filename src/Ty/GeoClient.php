<?php


namespace IotSpace\Ty;

use IotSpace\Support\HttpMethod;

/**
 * 地理位置服务
 * https://developer.tuya.com/cn/docs/cloud/2a97e08803?id=Kaingz6f9dhss
 * @package IotSpace\Ty
 */
class GeoClient extends BaseClient
{
    /**
     * 逆向地址解析，经纬度转地址
     * @param string $longitude 经度
     * @param string $latitude 纬度
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getAddress(string $longitude, string $latitude)
    {
        $url = "/v1.0/iot-03/geocode-cities/latitude-longitude?latitude={$latitude}&longitude={$longitude}";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 正地址解析，地址转经纬度
     * @param string $address
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getLonLat(string $address)
    {
        $url = "/v1.0/iot-03/geocode-cities/address?address={$address}";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 根据IP地址获取地理位置
     * @param string $ip
     * @return mixed
     * @throws \IotSpace\Exception\IotException
     */
    public function getIpLocation(string $ip)
    {
        $url = "/v1.0/iot-03/locations/ip?ip={$ip}";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

}