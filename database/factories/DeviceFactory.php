<?php

namespace Saleh\LaravelAppCommon\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Saleh\LaravelAppCommon\Helpers\Devices;
use Saleh\LaravelAppCommon\Models\Device;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition(): array
    {
        return [
            'deviceModel' => $this->faker->randomElement(array_keys(Devices::$appleDevices)),
            'deviceOS' => $this->faker->randomElement([
                'ios',
                'android',
            ]),
            'deviceID' => $this->faker->uuid(),
            'notificationToken' => $this->faker->uuid(),
            'deviceOSVersion' => $this->faker->randomDigit(),
        ];
    }
}
