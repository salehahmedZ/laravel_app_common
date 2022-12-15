<?php

use Carbon\Carbon;
use function Pest\Laravel\travel;
use function Pest\Laravel\travelBack;
use Saleh\LaravelAppCommon\Helpers\Code;

test('Code generate for Email Verification', function () {
    $now = Carbon::parse('2021-01-01 00:00:00');
    Carbon::setTestNow('2021-01-01 00:00:00');

    //Generate Email Verification Code
    $code = Code::generateEmailVerificationCode('test@test.com');
    expect($code)->toBeString()->toHaveLength(4);

    //Set Email Verification Email Send At
    $date = Code::setEmailVerificationEmailSendAt('test@test.com');
    expect($date)->toEqual($now);

    //Get Email Verification Code
    $codeResult = Code::getEmailVerificationCode('test@test.com');
    expect($codeResult)->toBe($code);

    //Get Email Verification Email Send At
    //still new expired after 5 minutes not 4. This is to prevent users from requesting a new code every time they click the resend button
    travel(4)->minutes();

    $date = Code::getEmailVerificationEmailSendAt('test@test.com');
    expect($date)->toEqual($now);

    travelBack();

    //expired after 5 minutes
    travel(6)->minutes();

    $date = Code::getEmailVerificationEmailSendAt('test@test.com');
    expect($date)->toBeNull();

    travelBack();
});

test('Code generate for Password Recovery', function () {
    $now = Carbon::parse('2021-01-01 00:00:00');
    Carbon::setTestNow('2021-01-01 00:00:00');

    //Generate Email Verification Code
    $code = Code::generatePasswordRecoveryCode('test@test.com');
    expect($code)->toBeString()->toHaveLength(5);

    //Set Email Verification Email Send At
    $date = Code::setPasswordRecoveryEmailSendAt('test@test.com');
    expect($date)->toEqual($now);

    //Get Email Verification Code
    $codeResult = Code::getPasswordRecoveryCode('test@test.com');
    expect($codeResult)->toBe($code);

    //Get Email Verification Email Send At
    //still new expired after 5 minutes not 4. This is to prevent users from requesting a new code every time they click the resend button
    travel(4)->minutes();

    $date = Code::getPasswordRecoveryEmailSendAt('test@test.com');
    expect($date)->toEqual($now);

    travelBack();

    //expired after 5 minutes
    travel(6)->minutes();

    $date = Code::getPasswordRecoveryEmailSendAt('test@test.com');
    expect($date)->toBeNull();

    travelBack();
});
