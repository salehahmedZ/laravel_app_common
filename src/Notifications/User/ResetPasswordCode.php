<?php

namespace Saleh\LaravelAppCommon\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordCode extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $code)
    {
        //
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())->theme('LaravelAppCommon::vendor.mail.html.themes.default')
                                  ->template('LaravelAppCommon::email')
                                  ->subject(trans('LaravelAppCommon::notification.Password recovery code'))
                                  ->greeting(trans('LaravelAppCommon::notification.hello'))
                                  ->line(trans('LaravelAppCommon::notification.Recovery code to restore your password'))
                                  ->line($this->code)
                                  ->line(trans('LaravelAppCommon::notification.thank you'))
                                  ->line(trans('LaravelAppCommon::notification.If you didnt ask to restore your password, ignore this email'))
                                  ->salutation(trans('LaravelAppCommon::notification.app name'));
    }
}
