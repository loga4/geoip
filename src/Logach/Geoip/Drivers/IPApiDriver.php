<?php
/**
 * Created by PhpStorm.
 * User: loga
 * Date: 27.02.15
 * Time: 21:34
 */

namespace Logach\Geoip\Drivers;

class IPApiDriver {

    public function getLocation($ip = null)
    {
        if(null === $ip) {
            $ip = $this->getClientIP();
        }


    }
}