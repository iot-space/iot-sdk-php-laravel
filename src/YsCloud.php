<?php

namespace IotSpace;

use IotSpace\Exception\IotException;
use IotSpace\Ys\BaseClient;
use IotSpace\Ys\TokenClient;
use IotSpace\Ys\UserClient;


/**
 * 萤石云SDK
 *
 * @method static TokenClient TokenClient()
 * @method static UserClient UserClient()
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
        $class = "IotSpace\\Ys\\{$name}";

        if (class_exists($class)) {
            return resolve($class);
        }

        throw new IotException("{$name} Not Found.");
    }
}
