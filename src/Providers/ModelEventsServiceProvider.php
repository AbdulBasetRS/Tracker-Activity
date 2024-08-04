<?php

namespace Abdulbaset\TrackerActivity\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Events\ModelCreated;
use Illuminate\Database\Eloquent\Events\ModelUpdated;
use Illuminate\Database\Eloquent\Events\ModelDeleted;
use Illuminate\Database\Eloquent\Events\ModelRestored;
use Illuminate\Database\Eloquent\Events\ModelForceDeleted;
use Abdulbaset\TrackerActivity\TrackerActivity;
use Illuminate\Support\Facades\Config;

class ModelEventsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $modelEventsConfig = Config::get('tracker-activity.events.model_events');

        if ($modelEventsConfig['created']) {
            Event::listen(ModelCreated::class, function ($event) {
                TrackerActivity::event('model_created', get_class($event->model), 'A model has been created.', $this->handleProperties('created', $event->model));
            });
        }

        if ($modelEventsConfig['updated']) {
            Event::listen(ModelUpdated::class, function ($event) {
                TrackerActivity::event('model_updated', get_class($event->model), 'A model has been updated.', $this->handleProperties('updated', $event->model));
            });
        }

        if ($modelEventsConfig['deleted']) {
            Event::listen(ModelDeleted::class, function ($event) {
                TrackerActivity::event('model_deleted', get_class($event->model), 'A model has been deleted.', $this->handleProperties('deleted', $event->model));
            });
        }

        if ($modelEventsConfig['restored']) {
            Event::listen(ModelRestored::class, function ($event) {
                TrackerActivity::event('model_restored', get_class($event->model), 'A model has been restored.', $this->handleProperties('restored', $event->model));
            });
        }

        if ($modelEventsConfig['force_deleted']) {
            Event::listen(ModelForceDeleted::class, function ($event) {
                TrackerActivity::event('model_force_deleted', get_class($event->model), 'A model has been force deleted.', $this->handleProperties('force_deleted', $event->model));
            });
        }
    }

    /**
     * Handle properties for logging based on the model event type.
     *
     * @param  string  $eventType
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return array
     */
    private function handleProperties($eventType, $model)
    {
        // Fetch the configuration value directly
        $dataOnlyChanges = Config::get('tracker-activity.data_only_changes', false);

        $properties = [
            'model_id' => $model->id,
            'data_only_changes' => $dataOnlyChanges,
        ];

        // Determine the properties based on event type
        switch ($eventType) {
            case 'updated':
                if ($dataOnlyChanges) {
                    $properties['old'] = (array_intersect_key($model->getOriginal(), $model->getChanges()));
                    $properties['new'] = ($model->getChanges());
                } else {
                    $properties['old'] = ($model->getOriginal());
                    $properties['new'] = ($model->toArray());
                }
                break;

            case 'deleted':
                $properties['old'] = ($model->getOriginal());
                $properties['new'] = null;
                break;

            case 'restored':
                $properties['old'] = null;
                $properties['new'] = ($model->toArray());
                break;

            case 'force_deleted':
                $properties['old'] = ($model->getOriginal());
                $properties['new'] = null;
                break;

            case 'created':
            default:
                $properties['old'] = null;
                $properties['new'] = ($model->toArray());
                break;
        }

        return $properties;
    }
}
