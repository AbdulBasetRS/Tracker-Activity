<?php

namespace Abdulbaset\TrackerActivity\Providers;

use Illuminate\Support\ServiceProvider;
use Abdulbaset\TrackerActivity\TrackerActivity;
use Abdulbaset\TrackerActivity\Exceptions\ActivityTrackerExceptionHandler;


class TrackerActivityServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register the facade alias
        $this->app->alias('TrackerActivity', \Abdulbaset\TrackerActivity\Facades\TrackerActivityFacade::class);
        
        $this->app->singleton(ExceptionHandler::class, ActivityTrackerExceptionHandler::class);

        // Publish config file
        $this->publishes([
            __DIR__.'/../Config/activity-tracker.php' => config_path('activity-tracker.php'),
        ]);

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../Migrations');
    }

    public function register()
    {
        $this->app->register(AuthEventsServiceProvider::class);
        $this->app->register(ModelEventsServiceProvider::class);
        $this->app->register(DatabaseEventsServiceProvider::class);
        $this->app->register(RequestEventsServiceProvider::class);
        $this->app->register(FileEventsServiceProvider::class);
        $this->app->register(SessionEventsServiceProvider::class);
        $this->app->register(RouteEventsServiceProvider::class);

        $this->mergeConfigFrom(
            __DIR__.'/../Config/activity-tracker.php', 'activity-tracker'
        );
        
        $this->app->singleton('activity-tracker', function ($app) {
            return new TrackerActivity();
        });
    }
}
