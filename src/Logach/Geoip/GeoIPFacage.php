<?php
/**
 * Created by PhpStorm.
 * User: loga
 * Date: 25.02.15
 * Time: 0:05
 */

namespace Logach\Geoip;

use Illuminate\Support\Facades\Facade;

class GeoIPFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'geoip'; }

}