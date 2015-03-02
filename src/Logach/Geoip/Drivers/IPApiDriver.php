<?php
/**
 * Created by PhpStorm.
 * User: loga
 * Date: 27.02.15
 * Time: 21:34
 */

namespace Logach\Geoip\Drivers;

use Guzzle\Common\Exception\ExceptionCollection;
use GuzzleHttp\Client as Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

class IPApiDriver {

    protected $lock;

    protected $limit;

    protected $limit_time = 30;

    public function __construct(array $config = ['limit' => 240])
    {
        $this->lock  = storage_path().'/geoip/req.lock';
        $this->limit = $config['limit'];

        $this->createStorageIfNotExists();
    }

    public function get($ip)
    {
        $client = new Client();

        try {
            $data = $client->get('http://ip-api.com/json/'.$ip)->json();

            if($data && $data['status']=='success') {
                return $data;
            }

        } catch(ConnectException $e) {
            return false;
        }

        return false;
    }

    protected function hasLimit()
    {
        $data = file_get_contents($this->lock);

        if(empty($data)) {
            return $this->newLock();
        } else {
            return $this->startLock($data);
        }
    }

    protected function newLock()
    {
        $data = [
            'start' => time(),
            'count' => 1
        ];

        file_put_contents($this->lock, serialize($data));

        return false;
    }

    protected function startLock($data)
    {
        $lock = unserialize($data);
        $time = time()-$lock['start'];

        if($time < $this->limit_time && $lock['count'] < $this->limit) {
            $lock['count']++;
            file_put_contents($this->lock, serialize($lock));
            return false;
        } elseif($time>$this->limit_time) {
            return $this->newLock();
        }

        return true;
    }

    protected function createStorageIfNotExists()
    {
        if(!is_dir(storage_path() . '/geoip')) {
            mkdir(storage_path() . '/geoip');
        }
        if (!is_file($this->lock)) {
            file_put_contents($this->lock, '');
        }
    }
}