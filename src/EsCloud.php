<?php

namespace IotSpace;

use IotSpace\Exception\IotException;
use IotSpace\Es\BaseClient;
use IotSpace\Es\DeviceClient;
use IotSpace\Es\DoorClient;
use IotSpace\Es\PersonClient;
use IotSpace\Es\TokenClient;


/**
 * 萤石SaaS开发服务后台SDK
 *
 * @method static TokenClient TokenClient()
 * @method static PersonClient PersonClient()
 * @method static DoorClient DoorClient()
 * @method static DeviceClient DeviceClient()
 *
 * @package IotSpace
 */
class EsCloud
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
        $class = "IotSpace\\Es\\{$name}";

        if (class_exists($class)) {
            return resolve($class);
        }

        throw new IotException("{$name} Not Found.");
    }
}
