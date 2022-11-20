<?php

namespace Saleh\LaravelAppCommon\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Sanctum\SanctumServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Saleh\LaravelAppCommon\LaravelAppCommonServiceProvider;
use Torann\GeoIP\GeoIPServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Saleh\\LaravelAppCommon\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelAppCommonServiceProvider::class,
            SanctumServiceProvider::class,
            GeoIPServiceProvider::class,

        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-app-auth_table.php.stub';
        $migration->up();
        */
    }
}
