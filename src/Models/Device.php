<?php

namespace Saleh\LaravelAppCommon\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User;
use Saleh\LaravelAppCommon\Database\Factories\DeviceFactory;
use Saleh\LaravelAppCommon\Events\DeviceWasCreated;


class Device extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function updateOrCreateDevice(array $deviceData): ?Device
    {
        $deviceID = $deviceData['deviceID'] ?? null;
        $notificationToken = $deviceData['notificationToken'] ?? null;

        //delete old devices
        $devices = null;
        if (! empty($deviceID) || ! empty($notificationToken)) {
            $devices = Device::query();
            if (! empty($deviceID) and ! empty($notificationToken)) {
                $devices->where('deviceID', $deviceID)->orWhere('notificationToken', $notificationToken);
            } elseif (! empty($deviceID)) {
                $devices->where('deviceID', $deviceID);
            } elseif (! empty($notificationToken)) {
                $devices->where('notificationToken', $notificationToken);
            }
        }

        $exist = false;
        if ($devices != null && $devices->count() > 0) {
            $devices->delete();
            $exist = true;
        }
        //

        if ($deviceID == null && $notificationToken == null) {
            return null;
        }

        $device = Device::create($deviceData);

        //send admin notification only if this is a new device and has no user
        if (! $exist && $device->user_id == null) {
            event(new DeviceWasCreated($device));
        }

        return $device;
    }

    protected static function newFactory(): DeviceFactory
    {
        return DeviceFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
