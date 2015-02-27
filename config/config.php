<?php
/**
 * Created by PhpStorm.
 * User: loga
 * Date: 27.02.15
 * Time: 21:05
 */

return [

    'driver' => 'ip-api',

    'drivers' => [
        'ip-api' => [
            'limit' => 200 //per minute
        ],
        'sypexgeo' => [
            'db_file' => 'SxGeoCity.dat'
        ]
    ]
];