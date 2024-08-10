<?php

namespace Abdulbaset\TrackerActivity\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Attempting;
use Abdulbaset\TrackerActivity\TrackerActivity;
use Illuminate\Support\Facades\Config;

class AuthEventsServiceProvider extends AuthServiceProvider
{
    public function boot()
    {
        $authEventsConfig = Config::get('tracker-activity.events.auth_events');

        if ($authEventsConfig['login']) {
            Event::listen(Login::class, function ($event) {
                TrackerActivity::auth('user_logged_in', $event->user, 'User has logged in.');
            });
        }

        if ($authEventsConfig['logout']) {
            Event::listen(Logout::class, function ($event) {
                TrackerActivity::auth('user_logged_out', $event->user, 'User has logged out.');
            });
        }

        if ($authEventsConfig['registered']) {
            Event::listen(Registered::class, function ($event) {
                TrackerActivity::auth('user_registered', $event->user, 'User has registered.');
            });
        }

        if ($authEventsConfig['failed']) {
            Event::listen(Failed::class, function ($event) {
                TrackerActivity::auth('user_login_failed', $event->user, 'User failed to log in.', [
                    'credentials' => $event->credentials
                ]);
            });
        }

        if ($authEventsConfig['verified']) {
            Event::listen(Verified::class, function ($event) {
                TrackerActivity::auth('user_verified', $event->user, 'User has verified their email.');
            });
        }

        if ($authEventsConfig['password_reset']) {
            Event::listen(PasswordReset::class, function ($event) {
                TrackerActivity::auth('password_reset', $event->user, 'User has reset their password.');
            });
        }

        if ($authEventsConfig['lockout']) {
            Event::listen(Lockout::class, function ($event) {
                TrackerActivity::auth('user_lockout', $event->user, 'User has been locked out.');
            });
        }

        if ($authEventsConfig['attempting']) {
            Event::listen(Attempting::class, function ($event) {
                TrackerActivity::auth('user_login_attempt', null, 'User is attempting to log in.', [
                    'credentials' => $event->credentials
                ]);
            });
        }
    }
}
