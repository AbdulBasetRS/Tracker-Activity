<?php

namespace Abdulbaset\TrackerActivity\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Session\Events\SessionStarted;
use Illuminate\Session\Events\SessionEnding;
use Abdulbaset\TrackerActivity\TrackerActivity;
use Illuminate\Support\Facades\Config;

class SessionEventsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $sessionEventsConfig = Config::get('tracker-activity.events.session_events');

        if ($sessionEventsConfig['session_started']) {
            Event::listen(SessionStarted::class, function ($event) {
                TrackerActivity::event('session_started', null, 'A session has started.', [
                    'session_id' => $event->session->getId(),
                ]);
            });
        }

        if ($sessionEventsConfig['session_ending']) {
            Event::listen(SessionEnding::class, function ($event) {
                TrackerActivity::event('session_ending', null, 'A session is ending.', [
                    'session_id' => $event->session->getId(),
                ]);
            });
        }
    }
}
