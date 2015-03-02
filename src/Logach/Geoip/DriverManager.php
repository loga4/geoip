<?php
/**
 * Created by PhpStorm.
 * User: loga
 * Date: 27.02.15
 * Time: 23:13
 */

namespace Logach\Geoip;

use Illuminate\Config\Repository;
use Logach\Geoip\Drivers\IPApiDriver;

class DriverManager {

    protected $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function getDriver($driver)
    {
        $method = 'get'.ucfirst(camel_case($driver)).'Driver';

        if(!method_exists($this, $method)) {
            throw new \Exception(sprintf('Cant find driver: %s', $driver));
        }

        return $this->$method(array_get($this->config->get('geoip::drivers'), $driver, []));
    }

    public function getIPApiDriver($config)
    {
        return new IPApiDriver($config);
    }

}