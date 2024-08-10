<?php

namespace Abdulbaset\TrackerActivity\Providers;

use Illuminate\Support\ServiceProvider;
use Abdulbaset\TrackerActivity\TrackerActivity;
use Abdulbaset\TrackerActivity\Exceptions\ActivityTrackerExceptionHandler;
use Illuminate\Contracts\Debug\ExceptionHandler;

class TrackerActivityServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register the facade alias
        $this->app->alias('TrackerActivity', \Abdulbaset\TrackerActivity\Facades\TrackerActivityFacade::class);
        
        $this->app->singleton(ExceptionHandler::class, ActivityTrackerExceptionHandler::class);

        // Publish config file
        $this->publishes([
            __DIR__.'/../Config/tracker-activity.php' => config_path('tracker-activity.php'),
        ]);

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../Migrations');
    }

    public function register()
    {
        $this->app->register(AuthEventsServiceProvider::class);
        $this->app->register(RouteEventsServiceProvider::class);
        $this->app->register(QueryBuilderServiceProvider::class);

        $this->mergeConfigFrom(
            __DIR__.'/../Config/tracker-activity.php', 'tracker-activity'
        );
        
        $this->app->singleton('tracker-activity', function ($app) {
            return new TrackerActivity();
        });
    }
}
