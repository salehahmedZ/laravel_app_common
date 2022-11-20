<?php

namespace Saleh\LaravelAppCommon\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Saleh\LaravelAppCommon\Models\Device;

class RequestData
{
    public static float $defaultLat = 23.8859;

    public static float $defaultLng = 45.0792;

    //device & user data
    public ?string $notificationToken;

    public ?string $deviceID;

    public ?string $deviceModel;

    public ?string $deviceOS;

    public ?string $deviceOSVersion;

    public ?string $appBuild;

    public ?string $appLang;

    public ?string $appThemeMode;

    //
    public ?string $ip;

    public ?float $latIp;

    public ?float $lngIp;

    public ?string $countryIp;

    public ?string $countryCodeIp;

    public ?string $cityIp;

    public ?string $userAgent;

    //

    public ?string $lat;

    public ?string $lng;

    //auth
    public ?string $email;

    public ?string $newEmail;

    public ?string $password;

    public ?string $currentPassword;

    public ?string $code;

    public ?string $name;

    public ?string $bio;

    public ?string $type;

    public ?string $description;

    public ?string $price;

    public ?string $avatar;

    public ?string $image;

    //
    public ?string $countryCode;

    //
    public ?array $cities;

    //
    public ?string $contactPhone;

    public ?string $contactPhoneCountryCode;

    //
    public ?bool $public;

    //
    public ?bool $allowWhatsapp;

    public ?bool $allowCalls;
    //

    //models ids
    public ?string $notificationID;

    public ?string $imageID;

    public ?string $tokenID;

    public ?string $userID;

    public ?array $usersIds;

    //synonyms
    public ?string $synonyms;

    public ?string $word;

    //words
    public ?string $wordID;

    public ?array $labels;

    public ?string $category;

    public ?string $keyword;

    public bool $isImpersonation;

    public function __construct(private Request $request)
    {
        $this->getIpData($request);

        $this->getData($request);
    }

    //called one time

    public function getIpData(Request $request): void
    {
        $this->userAgent = $request->userAgent();

        $locationData = new LocationDataFromIP(); //$this->ip

        $this->ip = $locationData->getIp();

        $this->countryIp = $locationData->getCountry();
        $this->countryCodeIp = $locationData->getCountryCode();
        $this->cityIp = $locationData->getCity();

        $this->latIp = $locationData->getLat();
        $this->lngIp = $locationData->getLng();

        $this->lat = $this->latIp;
        $this->lng = $this->lngIp;
    }

    //called one time

    private function getData(Request $request): void
    {
        //set Impersonation to prevent admin device from being added to users devices and prevent other things
        $this->isImpersonation = $request->header('X-Impersonation', false);

        //device
        $this->deviceID = $request->deviceID;
        $this->deviceModel = $request->deviceModel;
        $this->deviceOS = $request->deviceOS;
        $this->deviceOSVersion = $request->deviceOSVersion;
        $this->notificationToken = $request->notificationToken;

        //app
        $this->appBuild = $request->appBuild;
        $this->appLang = $request->appLang;
        $this->appThemeMode = $request->appThemeMode;

        //user data
        $this->email = $request->email;
        $this->newEmail = $request->newEmail;
        $this->password = $request->password;
        $this->currentPassword = $request->currentPassword;
        $this->code = $request->code;
        $this->name = $request->name;
        $this->bio = $request->bio;
        $this->type = $request->type;
        $this->avatar = $request->avatar;
        //
        $this->countryCode = $request->countryCode;
        //
        $this->allowCalls = $request->allowCalls;
        $this->allowWhatsapp = $request->allowWhatsapp;
        //
        $this->cities = $request->cities;
        //
        $this->contactPhone = $request->contactPhone;
        $this->contactPhoneCountryCode = $request->contactPhoneCountryCode;
        //
        $this->public = $request->public;
        $this->image = $request->image;
        $this->description = $request->description;
        $this->price = $request->price;

        //models ids
        $this->notificationID = $request->notificationID;
        $this->imageID = $request->imageID;
        $this->tokenID = $request->tokenID;
        $this->userID = $request->userID;
        $this->usersIds = $request->usersIds;

        //location
        $this->lat = $request->lat ?? $this->user()?->lat ?? $this->latIp ?? self::$defaultLat;
        $this->lng = $request->lng ?? $this->user()?->lng ?? $this->lngIp ?? self::$defaultLng;

        $this->word = $request->word;
        $this->synonyms = $request->synonyms;

        //words
        $this->wordID = $request->wordID;
        $this->labels = $request->labels;
        $this->category = $request->category;

        //search
        $this->keyword = $request->keyword;
    }

    public function user(): ?Model
    {
        $user = $this->request->user('sanctum');

        if ($user != null && $this->isImpersonation === true) {
            $user->timestamps = false;
        }

        return $user;
    }

    public static function instance(Request $newRequest = null): RequestData
    {
        $re = app(self::class);
        if ($newRequest != null) {
            $re->setNewRequest($newRequest);
        }

        return $re;
    }

    private function setNewRequest(Request $newRequest = null): void
    {
        if ($newRequest != null) {
            $this->request = $newRequest;
            $this->getIpData($newRequest);
            $this->getData($newRequest);
        }
    }

    public function device(): ?Device
    {
        $device = null;
        if (! empty($this->deviceID)) {
            $device = Device::where('deviceID', $this->deviceID)->first();
        }

        if (empty($device) && ! empty($this->notificationToken)) {
            $device = Device::where('notificationToken', $this->notificationToken)->first();
        }

        return $device;
    }

    public function deviceData(?int $userID = null): array
    {
        if ($this->isImpersonation) {
            return [];
        }

        return [
            'user_id' => $this->user()?->id ?? $userID,
            'notificationToken' => $this->notificationToken,

            'deviceModel' => $this->deviceModel,
            'deviceOS' => $this->deviceOS,
            'deviceOSVersion' => $this->deviceOSVersion,
            'deviceID' => $this->deviceID,

            'appBuild' => $this->appBuild,
            'appLang' => $this->appLang,
            'appThemeMode' => $this->appThemeMode,

            'ip' => $this->ip,
            'countryIp' => $this->countryIp,
            'countryCodeIp' => $this->countryCodeIp,
            'cityIp' => $this->cityIp,
        ];
    }

    public function metaData(array $userAttributes = []): array
    {
        if ($this->isImpersonation) {
            return $userAttributes;
        }

        return array_merge($userAttributes, [
            'appLang' => $this->appLang,
            'countryIp' => $this->countryIp,
            'countryCodeIp' => $this->countryCodeIp,
            'cityIp' => $this->cityIp,
        ]);
    }

    public function __get(string $name)
    {
        return $this->request->{$name};
    }
}
