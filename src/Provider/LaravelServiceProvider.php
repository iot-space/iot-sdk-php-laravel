<?php


namespace IotSpace\Provider;

use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // 发布配置文件
        $this->publishes([realpath(__DIR__.'/../../config/iot.php') => config_path('iot.php')]);
    }

    public function register()
    {
//        $this->app->singleton(TokenClient::class, function ($app) {
//            return new TokenClient($app);
//        });
    }

    /**
     * Array of config items that are instantiable.
     *
     * @var array
     */
    protected $instantiable = [
        'ty', 'ys'
    ];

    /**
     * Retrieve and instantiate a config value if it exists and is a class.
     *
     * @param string $item
     * @param bool   $instantiate
     *
     * @return mixed
     */
    protected function config($item, $instantiate = true)
    {
        $value = $this->app['config']->get('iot.'.$item);

        if (is_array($value)) {
            return $instantiate ? $this->instantiateConfigValues($item, $value) : $value;
        }

        return $instantiate ? $this->instantiateConfigValue($item, $value) : $value;
    }

    /**
     * Instantiate an array of instantiable configuration values.
     *
     * @param string $item
     * @param array  $values
     *
     * @return array
     */
    protected function instantiateConfigValues($item, array $values)
    {
        foreach ($values as $key => $value) {
            $values[$key] = $this->instantiateConfigValue($item, $value);
        }

        return $values;
    }

    /**
     * Instantiate an instantiable configuration value.
     *
     * @param string $item
     * @param mixed  $value
     *
     * @return mixed
     */
    protected function instantiateConfigValue($item, $value)
    {
        if (is_string($value) && in_array($item, $this->instantiable)) {
            return $this->app->make($value);
        }

        return $value;
    }
}
