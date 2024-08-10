<?php

namespace Abdulbaset\TrackerActivity\Listeners;

use Illuminate\Routing\Events\RouteMatched;
use Abdulbaset\TrackerActivity\TrackerActivity;

class RouteVisitListener
{
    public static function handle(RouteMatched $event)
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
            'Visited page: ' . $request->path(),
            [
                'type' => $requestType,
            ]
        );
    }
}
