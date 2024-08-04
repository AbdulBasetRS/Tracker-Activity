<?php

namespace Abdulbaset\TrackerActivity\Listeners;

use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Routing\Events\RouteNotFound;
use Illuminate\Support\Facades\Log;
use Abdulbaset\TrackerActivity\TrackerActivity;

class RouteVisitListener
{
    /**
     * Log visits to matched routes.
     *
     * @param RouteMatched $event
     * @return void
     */
    public static function logVisit(RouteMatched $event)
    {
        $request = $event->request;

        // Determine the type of request
        if ($request->is('api/*')) {
            $requestType = 'API';
        } elseif ($request->isXmlHttpRequest()) {
            $requestType = 'AJAX';
        } else {
            $requestType = 'Web';
        }

        TrackerActivity::visited(
            null,
            null,
            'Visited page: ' . $request->path(),
            [
                'type' => $requestType,
            ]
        );
    }

    /**
     * Log attempts to access a route that was not found.
     *
     * @param RouteNotFound $event
     * @return void
     */
    public static function logNotFound(RouteNotFound $event)
    {
        $request = $event->request;

        // Determine the type of request
        if ($request->is('api/*')) {
            $requestType = 'API';
        } elseif ($request->isXmlHttpRequest()) {
            $requestType = 'AJAX';
        } else {
            $requestType = 'Web';
        }

        TrackerActivity::visited(
            'route_not_found',
            null,
            'Attempted to access non-existent route: [ ' . $request->path() . ' ]',
            [
                'type' => $requestType,
            ]
        );
    }
}
