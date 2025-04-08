<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Carbon::setToStringFormat(config('app.date_time_format'));
        Paginator::defaultView('vendor.pagination.bootstrap-5');

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)->subject(trans('auth.verify_email.email_subject'))->line(trans('auth.verify_email.email_content'))->action(trans('auth.verify_email.email_subject'), $url);
        });

        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $url = url(route('password.reset', ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset(),], false));

            return (new MailMessage)->subject(trans('auth.reset_password.reset_email_subject'))->line(trans('auth.reset_password.reset_email_content'))->action(trans('auth.reset_password.main_title'), $url)->line(trans('auth.reset_password.reset_email_line_one', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))->line(trans('auth.reset_password.reset_email_line_two'));
        });
    }
}
