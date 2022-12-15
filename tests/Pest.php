<?php

//use Illuminate\Auth\GenericUser;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Testing\TestResponse;
use function Pest\Laravel\withoutExceptionHandling;
use Saleh\LaravelAppCommon\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);
uses(LazilyRefreshDatabase::class)->in(__DIR__);

const contactUs = [
    'whatsapp' => '',
    'twitter' => '',
    'snapchat' => '',
    'email' => '',
    'instagram' => '',
];

const appVersion = [
    'ios' => 0,
    'android' => 0,
    'forceUpdate' => false,
];

const appMsg = [
    'text' => [
        'ar' => '',
        'en' => '',
    ],
    'type' => 'success',
    'os' => 'both',
    'forBuild' => 0,
    'forBuildOperator' => '',
    'countryCode' => 'all',
];

function mustBeAdmin($url): TestResponse
{
    withoutExceptionHandling();

    return test()->postJson($url)
                 ->assertJsonPath('success', false)
                 ->assertJsonPath('msg', trans('LaravelAppCommon::api.You are not an admin'));
}

function actingAsAdmin($guard = null)
{
    $user = new User([]);
    $user->id = 1;
    $user->isAdmin = true;
    test()->actingAs($user, $guard ?? 'sanctum');

    return $user;
}
