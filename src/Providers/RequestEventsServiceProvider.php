<?php

namespace Abdulbaset\TrackerActivity\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Http\Events\RequestHandled;
use Illuminate\Http\Events\RequestFailed;
use Abdulbaset\TrackerActivity\TrackerActivity;
use Illuminate\Support\Facades\Config;

class RequestEventsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $requestEventsConfig = Config::get('tracker-activity.events.request_events');

        if ($requestEventsConfig['request_handled']) {
            Event::listen(RequestHandled::class, function ($event) {
                TrackerActivity::event('request_handled', null, 'A request was handled.', [
                    'request' => $event->request->all(),
                    'response' => $event->response->getContent(),
                ]);
            });
        }

        if ($requestEventsConfig['request_failed']) {
            Event::listen(RequestFailed::class, function ($event) {
                TrackerActivity::event('request_failed', null, 'A request failed.', [
                    'exception' => $event->exception->getMessage(),
                ]);
            });
        }
    }
}
