<?php

namespace Abdulbaset\TrackerActivity\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\Events\MigrationsStarted;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Database\Events\MigrationStarted;
use Illuminate\Database\Events\MigrationEnded;
use Illuminate\Database\Events\SchemaLoaded;
use Illuminate\Support\Facades\Config;
use Abdulbaset\TrackerActivity\TrackerActivity;

class DatabaseEventsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $dbEventsConfig = Config::get('tracker-activity.events.db_events');

        if ($dbEventsConfig['query_executed']) {
            Event::listen(QueryExecuted::class, function ($event) {
                TrackerActivity::event('query_executed', null, 'A database query was executed.', [
                    'query' => $event->sql,
                    'bindings' => $event->bindings,
                    'time' => $event->time,
                ]);
            });
        }

        if ($dbEventsConfig['migrations_started']) {
            Event::listen(MigrationsStarted::class, function ($event) {
                TrackerActivity::event('migrations_started', null, 'Database migrations have started.');
            });
        }

        if ($dbEventsConfig['migrations_ended']) {
            Event::listen(MigrationsEnded::class, function ($event) {
                TrackerActivity::event('migrations_ended', null, 'Database migrations have ended.');
            });
        }

        if ($dbEventsConfig['migration_started']) {
            Event::listen(MigrationStarted::class, function ($event) {
                TrackerActivity::event('migration_started', $event->migration, 'A database migration has started.', [
                    'migration' => $event->migration,
                ]);
            });
        }

        if ($dbEventsConfig['migration_ended']) {
            Event::listen(MigrationEnded::class, function ($event) {
                TrackerActivity::event('migration_ended', $event->migration, 'A database migration has ended.', [
                    'migration' => $event->migration,
                ]);
            });
        }

        if ($dbEventsConfig['schema_loaded']) {
            Event::listen(SchemaLoaded::class, function ($event) {
                TrackerActivity::event('schema_loaded', null, 'Database schema has been loaded.');
            });
        }
    }
}
