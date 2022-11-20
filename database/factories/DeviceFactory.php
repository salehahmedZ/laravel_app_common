<?php

namespace Saleh\LaravelAppCommon\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Auth\User;
use Saleh\LaravelAppCommon\Helpers\AppleDevices;
use Saleh\LaravelAppCommon\Models\Device;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition(): array
    {

        /** @var User $userModel */
        $userModel = config('app-common.userModel');

        return [
            'deviceModel' => $this->faker->randomElement(array_keys(AppleDevices::$appleDevices)),
            'deviceOS' => $this->faker->randomElement([
                'ios',
                'android',
            ]),
            'deviceID' => $this->faker->uuid(),
            'notificationToken' => $this->faker->uuid(),
            'deviceOSVersion' => $this->faker->randomDigit(),
            'user_id' => $userModel::factory(),
        ];
    }
}
