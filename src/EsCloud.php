<?php

namespace IotSpace;

use IotSpace\Exception\IotException;
use IotSpace\Ys\BaseClient;
use IotSpace\Ys\DeviceClient;
use IotSpace\Ys\DoorClient;
use IotSpace\Ys\PersonClient;
use IotSpace\Ys\SaasClient;
use IotSpace\Ys\TokenClient;


/**
 * 萤石SaaS开发服务后台SDK
 *
 * @method static TokenClient TokenClient()
 * @method static PersonClient PersonClient()
 * @method static DoorClient DoorClient()
 * @method static DeviceClient DeviceClient()
 * @method static SaasClient SaasClient()
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
