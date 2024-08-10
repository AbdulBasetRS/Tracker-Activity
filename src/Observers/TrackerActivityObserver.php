<?php

namespace Abdulbaset\TrackerActivity\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use TrackerActivity;

class TrackerActivityObserver
{

    private static $logging = false;

    /**
     * Handle the model "retrieved" event.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function retrieved(Model $model)
    {
        if (\TrackerActivity::checkRetrieved()) {
            \TrackerActivity::setRetrieved(false);
            return;
        }

        $auth_model = Config::get('tracker.auth_model');
        $auth_model = $auth_model ? get_class($auth_model) : '\App\Models\User';

        if (self::$logging) {
            return;
        }

        // Set logging flag to true
        self::$logging = true;

        try {
            // Skip logging if the model is the authenticated user
            if (Auth::check() && $model instanceof $auth_model && $model->id === Auth::id()) {
                return;
            }

            // Log the activity
            TrackerActivity::model('model_retrieved', $model, 'Model retrieved from general observer', [
                'model_id' => $model->id,
                'data' => $model->toArray(),
            ]);
        } finally {

            // Reset logging flag
            self::$logging = false;
        }
    }

    /**
     * Handle model creation.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $entity
     * @return void
     */
    public function created(Model $entity)
    {
        TrackerActivity::model('model_created', $entity, 'Entity created From Observer', $this->handleProperties('created', $entity));
    }

    /**
     * Handle model update.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $entity
     * @return void
     */
    public function updated(Model $entity)
    {
        TrackerActivity::model('model_updated', $entity, 'Entity updated From Observer', $this->handleProperties('updated', $entity));
    }

    /**
     * Handle model deletion.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $entity
     * @return void
     */
    public function deleted(Model $entity)
    {
        TrackerActivity::model('model_deleted', $entity, 'Entity deleted From Observer', $this->handleProperties('deleted', $entity));
    }

    /**
     * Handle model restoration from soft delete.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $entity
     * @return void
     */
    public function restored(Model $entity)
    {
        TrackerActivity::model('model_restored', $entity, 'Entity restored From Observer', $this->handleProperties('restored', $entity));
    }

    /**
     * Handle model force deletion.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $entity
     * @return void
     */
    public function forceDeleted(Model $entity)
    {
        TrackerActivity::model('model_force_deleted', $entity, 'Entity force deleted From Observer', $this->handleProperties('force_deleted', $entity));
    }

    /**
     * Handle model properties based on the event type.
     *
     * @param  string $eventType
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return array
     */
    private function handleProperties($eventType, $model)
    {
        $dataOnlyChanges = Config::get('tracker-activity.data_only_changes', false);

        $properties = [
            'model_id' => $model->id,
            'data_only_changes' => $dataOnlyChanges,
        ];

        switch ($eventType) {
            case 'updated':
                if ($dataOnlyChanges) {
                    $properties['old'] = array_intersect_key($model->getOriginal(), $model->getChanges());
                    $properties['new'] = $model->getChanges();
                } else {
                    $properties['old'] = $model->getOriginal();
                    $properties['new'] = $model->toArray();
                }
                break;

            case 'deleted':
                $properties['old'] = $model->getOriginal();
                $properties['new'] = null;
                break;

            case 'restored':
                $properties['old'] = null;
                $properties['new'] = $model->toArray();
                break;

            case 'force_deleted':
                $properties['old'] = $model->getOriginal();
                $properties['new'] = null;
                break;

            case 'created':
            default:
                $properties['old'] = null;
                $properties['new'] = $model->toArray();
                break;
        }

        return $properties;
    }
}
