<?php

namespace Abdulbaset\TrackerActivity\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Routing\Events\RouteNotFound;
use Illuminate\Support\ServiceProvider;
use Abdulbaset\TrackerActivity\Listeners\RouteVisitListener;
use Illuminate\Support\Facades\Config;

class RouteEventsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $routeEventsConfig = Config::get('tracker-activity.events.route_events');

        if ($routeEventsConfig['route_matched']) {
            Event::listen(RouteMatched::class, [RouteVisitListener::class, 'handle']);
        }
    }
}
