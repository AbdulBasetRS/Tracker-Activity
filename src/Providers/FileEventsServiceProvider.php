<?php

namespace Abdulbaset\TrackerActivity\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Filesystem\Events\FileCreated;
use Illuminate\Filesystem\Events\FileDeleted;
use Illuminate\Filesystem\Events\FileUpdated;
use Abdulbaset\TrackerActivity\TrackerActivity;
use Illuminate\Support\Facades\Config;

class FileEventsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $fileEventsConfig = Config::get('tracker-activity.events.file_events');

        if ($fileEventsConfig['file_created']) {
            Event::listen(FileCreated::class, function ($event) {
                TrackerActivity::event('file_created', $event->file, 'A file has been created.', [
                    'file_path' => $event->file->getPathname(),
                ]);
            });
        }

        if ($fileEventsConfig['file_deleted']) {
            Event::listen(FileDeleted::class, function ($event) {
                TrackerActivity::event('file_deleted', $event->file, 'A file has been deleted.', [
                    'file_path' => $event->file->getPathname(),
                ]);
            });
        }

        if ($fileEventsConfig['file_updated']) {
            Event::listen(FileUpdated::class, function ($event) {
                TrackerActivity::event('file_updated', $event->file, 'A file has been updated.', [
                    'file_path' => $event->file->getPathname(),
                ]);
            });
        }
    }
}
