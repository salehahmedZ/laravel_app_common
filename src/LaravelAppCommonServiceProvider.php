<?php

namespace Saleh\LaravelAppCommon;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Saleh\LaravelAppCommon\Helpers\RequestData;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelAppCommonServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-app-common')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations(['create_devices_table']);
    }

    public function bootingPackage()
    {
        Model::preventLazyLoading(! $this->app->isProduction());

        Model::preventSilentlyDiscardingAttributes(! $this->app->isProduction());

        Model::shouldBeStrict(! $this->app->isProduction());

        $this->app->scoped(RequestData::class, fn ($app) => new RequestData($app['request']));
    }

    public function packageBooted()
    {
        $this->registerRateLimits();

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'LaravelAppCommon');

        //$this->loadViewsFrom(__DIR__.'/../resources/views', 'LaravelAppCommon');

//        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }

    private function getApiLimit(Request $request, int $attempts): Limit
    {
        return Limit::perMinute($attempts)->by($request->user('sanctum')?->id ?? $request->ip())->response(fn () => response()->json([
            'msg' => trans('LaravelAppCommon::api.Too many attempts'),
            'success' => false,
        ]));
    }

    private function registerRateLimits(): void
    {
        RateLimiter::for('api5', fn (Request $request) => $this->getApiLimit($request, 5));

        RateLimiter::for('api10', fn (Request $request) => $this->getApiLimit($request, 10));

        RateLimiter::for('api50', fn (Request $request) => $this->getApiLimit($request, 50));
    }
}
