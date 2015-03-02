<?php
/**
 * Created by PhpStorm.
 * User: loga
 * Date: 25.02.15
 * Time: 0:04
 */

namespace Logach\Geoip;

use Illuminate\Config\Repository;

class GeoIP {

    protected $ip;

    protected $driver;

    public function __construct(Repository $config)
    {
        $this->driver = (new DriverManager($config))->getDriver($config->get('geoip::driver'));
    }

    public function getLocation($ip = null)
    {
        if(null === $ip) {
            $ip = $this->getClientIP();
        }

        $location = $this->getDriver()->get($ip);

        return ($location) ?: false;
    }

    protected function getDriver()
    {
        return $this->driver;
    }

    protected function find($ip = null)
    {
        $geo = new SxGeo($this->db_location);

        $location = $geo->getCityFull($ip);

        return $location;
    }

    private function getClientIP()
    {
        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        }
        else if(getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        }
        else if(getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        }
        else if(getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        }
        else if(getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        }
        else if(getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        }
        else if(isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        }
        else {
            $ipaddress = '127.0.0.0';
        }

        return $ipaddress;
    }

}