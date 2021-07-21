<?php


namespace IotSpace\Ty;

use IotSpace\Support\HttpMethod;

/**
 * 天气服务
 * https://developer.tuya.com/cn/docs/cloud/e27b2726b5?id=Kaingyin56beu
 * @package IotSpace\Ty
 */
class WeatherClient extends BaseClient
{
    /**
     * 根据经纬度获取当前天气情况
     * @param string $lon 经度
     * @param string $lat 纬度
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function getTodayWeather(string $lon, string $lat)
    {
        $url = "/v2.0/iot-03/weather/current?lat={$lat}&lon={$lon}";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }

    /**
     * 根据经纬度获取7日天气预报
     * @param string $lon
     * @param string $lat
     * @return mixed
     * @throws \IotSpace\Exception\ClientException
     */
    public function getWeekWeather(string $lon, string $lat)
    {
        $url = "/v2.0/iot-03/weather/forecast/daily?lat={$lat}&lon={$lon}";

        $data = $this->getHttpRequest($url, HttpMethod::GET, true);

        return $data;
    }
}