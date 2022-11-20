<?php

namespace Saleh\LaravelAppCommon\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class Localization
{
    public function handle(Request $request, Closure $next)
    {
        $defaultLocale = 'ar';
        $supportedLocalization = [
            'en',
            'ar',
        ];

        $userAppLang = $request->user?->appLang;
        $headerLang = $request->header('x-localization');

        // Check user app lang and header request to determine locale or use default locale
        $local = $userAppLang ?? $headerLang ?? $defaultLocale;

        // set laravel localization
        if (in_array($local, $supportedLocalization)) {
            app()->setLocale($local);
            Carbon::setLocale($local);
        } else {
            app()->setLocale($defaultLocale);
            Carbon::setLocale($defaultLocale);
        }

        // continue request
        return $next($request);
    }
}
