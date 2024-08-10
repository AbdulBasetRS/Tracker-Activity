<?php

namespace Abdulbaset\TrackerActivity\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use TrackerActivity;

class QueryBuilderServiceProvider extends ServiceProvider
{
    public function register()
    {
        // No additional services need to be registered for this functionality
    }

    public function boot()
    {
        Builder::macro('setRetrieved', function () {
          
            TrackerActivity::setRetrieved();

            return $this;
        });
    }
}
