<?php

namespace Saleh\LaravelAppCommon\Database\Seeders;

use Illuminate\Database\Seeder;
use Saleh\LaravelAppCommon\Models\Device;

class DatabaseSeeder extends Seeder
{
    //art db:seed "Saleh\LaravelAppCommon\Database\Seeders\DatabaseSeeder"

    public function run()
    {
        Device::factory()->count(10)->create();
    }
}
