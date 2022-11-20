<?php

namespace Saleh\LaravelAppCommon\Helpers;

class Distance
{
    public static function get($lat1, $lng1, $lat2, $lng2): float|int
    {
        if (($lat1 == $lat2) && ($lng1 == $lng2)) {
            return 0;
        } else {
            return self::haversineGreatCircleDistance($lat1, $lng1, $lat2, $lng2) / 1000;
            //$theta = $lng1 - $lng2;
            //$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            //$dist = acos($dist);
            //$dist = rad2deg($dist);
            //$miles = $dist * 60 * 1.1515;
            //$unit = strtoupper($unit);
            //return $miles * 1.609344;
        }
    }

    private static function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {// convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * 6371000;
    }
}
