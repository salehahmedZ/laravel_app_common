<?php

namespace Saleh\LaravelAppCommon\Helpers;

use Illuminate\Support\Facades\Config;
use Torann\GeoIP\GeoIP;
use Torann\GeoIP\Location;

class LocationDataFromIP
{
    private GeoIP|Location $geoip;

    public function __construct($ip = null)
    {
        $ip = $ip ?? $this->getIp();

        Config::set('geoip.cache_tags', false);
        $this->geoip = geoip($ip);
    }

    public function getIp(): ?string
    {
        foreach ([
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        ] as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }

        return request()->ip(); // it will return server ip when no client ip found
    }

    public function getCountry(): string
    {
        return $this->geoip->country;
    }

    public function getCountryCode(): string
    {
        return $this->geoip->iso_code;
    }

    public function getCity(): string
    {
        return $this->geoip->city;
    }

    public function getLat(): ?float
    {
        return $this->geoip->lat;
    }

    public function getLng(): ?float
    {
        return $this->geoip->lon;
    }
}
