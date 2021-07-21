<?php

namespace IotSpace;

use IotSpace\Exception\ClientException;


/**
 * 涂鸦云SDK
 *
 * @method static TokenClient TokenClient()
 * @method static UserClient UserClient()
 * @method static SceneClient SceneClient()
 * @method static HomeClient HomeClient()
 * @method static DataClient DataClient()
 * @method static DeviceClient DeviceClient()
 * @method static PairTokenClient PairTokenClient()
 * @method static TimeClient TimeClient()
 * @method static WeatherClient WeatherClient()
 * @method static GeoClient GeoClient()
 * @method static SmsClient SmsClient()
 *
 * @package IotSpace
 */
class YsCloud
{
    private function __construct()
    {

    }

    /**
     * Dynamically pass methods to the application.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        /**
         * @var BaseClient
         */
        $class = "IotSpace\\Ty\\{$name}";

        if (class_exists($class)) {
            return resolve($class);
        }

        throw new ClientException("{$name} Not Found.");
    }
}
