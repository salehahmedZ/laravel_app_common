<?php

namespace Saleh\LaravelAppCommon\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Code
{
    public static function generateEmailVerificationCode($email): string
    {
        $code = self::_generateEmailVerificationCode();
        Cache::put(self::getEmailVerificationCodeKey($email), $code, now()->addMinutes(30));

        return (string) $code;
    }

    private static function _generateEmailVerificationCode(): int
    {
        return random_int(1000, 9999);
    }

    private static function getEmailVerificationCodeKey($email): string
    {
        return 'user.'.md5($email).'.emailCode';
    }

    private static function getEmailVerificationSentAtKey($email): string
    {
        return 'user.'.md5($email).'.EmailVerificationEmailSendAt';
    }

    public static function getEmailVerificationCode($email): string|null
    {
        return (string) Cache::get(self::getEmailVerificationCodeKey($email));
    }

    ////////////////////////////////////////////////////////////

    public static function generatePasswordRecoveryCode($email): string
    {
        $code = self::_generatePasswordRecoveryCode();
        Cache::put(self::getPasswordRecoveryCodeKey($email), $code, now()->addMinutes(30));

        return (string) $code;
    }

    private static function _generatePasswordRecoveryCode(): int
    {
        return random_int(10000, 99999);
    }

    private static function getPasswordRecoveryCodeKey($email): string
    {
        return 'user.'.md5($email).'.passwordResetCodeKey';
    }

    private static function getPasswordRecoverySentAtKey($email): string
    {
        return 'user.'.md5($email).'.PasswordRecoveryEmailSendAt';
    }

    public static function getPasswordRecoveryCode($email): string|null
    {
        return (string) Cache::get(self::getPasswordRecoveryCodeKey($email));
    }

    ////////////////////////////////////////////////////////////

    public static function setEmailVerificationEmailSendAt($email): Carbon
    {
        Cache::put(self::getEmailVerificationSentAtKey($email), now()->timestamp, now()->addMinutes(5));

        return Carbon::now();
    }

    public static function getEmailVerificationEmailSendAt($email): Carbon|null
    {
        $val = Cache::get(self::getEmailVerificationSentAtKey($email));
        if (empty($val)) {
            return null;
        } else {
            return Carbon::createFromTimestamp($val);
        }
    }

    ////////////////////////////////////////////////////////////

    public static function setPasswordRecoveryEmailSendAt($email): Carbon
    {
        Cache::put(self::getPasswordRecoverySentAtKey($email), now()->timestamp, now()->addMinutes(5));

        return Carbon::now();
    }

    public static function getPasswordRecoveryEmailSendAt($email): Carbon|null
    {
        $val = Cache::get(self::getPasswordRecoverySentAtKey($email));
        if (empty($val)) {
            return null;
        } else {
            return Carbon::createFromTimestamp($val);
        }
    }
}

//public static function getDistance($lat1, $lng1, $lat2, $lng2): float|int
//{
//    if (($lat1 == $lat2) && ($lng1 == $lng2)) {
//        return 0;
//    } else {
//        return self::haversineGreatCircleDistance($lat1, $lng1, $lat2, $lng2) / 1000;
//        //$theta = $lng1 - $lng2;
//        //$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
//        //$dist = acos($dist);
//        //$dist = rad2deg($dist);
//        //$miles = $dist * 60 * 1.1515;
//        //$unit = strtoupper($unit);
//        //return $miles * 1.609344;
//    }
//}
//
//private static function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
//{// convert from degrees to radians
//    $latFrom = deg2rad($latitudeFrom);
//    $lonFrom = deg2rad($longitudeFrom);
//    $latTo = deg2rad($latitudeTo);
//    $lonTo = deg2rad($longitudeTo);
//
//    $latDelta = $latTo - $latFrom;
//    $lonDelta = $lonTo - $lonFrom;
//
//    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
//
//    return $angle * 6371000;
//}
//
//public static function removeEmptyLines(string $string): string
//{
//    return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);
//}
