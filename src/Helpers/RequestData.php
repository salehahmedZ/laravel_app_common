<?php

namespace Saleh\LaravelAppCommon\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Saleh\LaravelAppCommon\Models\Device;

class RequestData
{
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

    public string|float|null $lat;

    public string|float|null $lng;

    //
    public ?string $countryCode;

    public bool $isImpersonation;

    public function __construct(private Request $request)
    {
        $this->getIpData($request);

        $this->getData($request);
    }

    //called one time

    public function getIpData(?Request $request = null): void
    {
        $request = $request ?? $this->request;
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
        $this->isImpersonation = $request->header('X-Impersonation', false) == true;

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

        //
        $this->countryCode = $request->countryCode;

        //location
        $this->lat = $request->lat ?? $this->latIp;
        $this->lng = $request->lng ?? $this->lngIp;
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
        //dd($this->notificationToken);
        $device = null;
        if (! empty($this->deviceID) || ! empty($this->notificationToken)) {
            $device = Device::where('deviceID', $this->deviceID)
                            ->when(! empty($this->notificationToken), fn ($q) => $q->orWhere('notificationToken', $this->notificationToken))
                            ->first();
        }

        //if (empty($device) && ! empty($this->notificationToken)) {
        //    $device = Device::where('notificationToken', $this->notificationToken)->first();
        //}

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
