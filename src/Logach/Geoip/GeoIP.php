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
        print_r($config);
        //$this->db_location = app_path().'/database/sypexgeo/'.$this->db_name;

        /*if(!is_file($this->db_location)) {
            throw new \Exception('Cant find file:'.$this->db_location);
        }*/

        die;
    }

    public function getLocation($ip = null)
    {
        if(null === $ip) {
            $ip = $this->getClientIP();
        }

        $location = $this->find($ip);

        if($location) {
            return $location;
        }

        return false;
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