<?php

namespace Saleh\LaravelAppCommon\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Auth\User;
use Saleh\LaravelAppCommon\Models\Device;
use Saleh\LaravelAppCommon\Helpers\AppleDevices;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition(): array
    {
        return [
            'deviceModel' => $this->faker->randomElement(array_keys(AppleDevices::$appleDevices)),
            'deviceOS' => $this->faker->randomElement([
                'ios',
                'android',
            ]),
            'deviceID' => $this->faker->uuid(),
            'notificationToken' => $this->faker->uuid(),
            'deviceOSVersion' => $this->faker->randomDigit(),
            'user_id' => User::factory(),
        ];
    }
}