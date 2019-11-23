<?php
/**
 * Created by PhpStorm.
 * User: Djunehor
 * Date: 10/5/2019
 * Time: 1:27 AM.
 */

namespace Djunehor\EventRevert;

use Djunehor\EventRevert\ModelLog as Activity;
use Illuminate\Database\Eloquent\Model;

/**
 *  Automatically Log Add, Update, Delete events of Model.
 */
trait ModelEventLogger
{
    /**
     * Automatically boot with Model, and register Events handler.
     */
    protected static function boot()
    {
        parent::boot();

        foreach (static::getRecordActivityEvents() as $eventName) {
            static::$eventName(function (Model $model) use ($eventName) {
                try {
                    $reflect = new \ReflectionClass($model);

                    return Activity::create([
                        'causer_id'     => auth()->id(),
                        'causer_type'     => auth()->check() ? get_class(auth()->user()) : null,
                        'subject_id'   => $model->id,
                        'subject_type' => get_class($model),
                        'action'      => static::getActionName($eventName),
                        'description' => ucfirst($eventName).' a '.$reflect->getShortName(),
                        'old'     => json_encode($model->getOriginal()),
                        'new'     => json_encode($model->getDirty()),
                        'route'     => (php_sapi_name() === 'cli' or defined('STDIN')) ? null : request()->url(),
                    ]);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            });
        }
    }

    /**
     * Set the default events to be recorded if the $recordEvents
     * property does not exist on the model.
     *
     * @return array
     */
    protected static function getRecordActivityEvents()
    {
        if (isset(static::$recordEvents)) {
            return static::$recordEvents;
        }

        return [
            'created',
            'updated',
            'deleted',
//			'inserted',
        ];
    }

    /**
     * Return Suitable action name for Supplied Event.
     *
     * @param $event
     * @return string
     */
    protected static function getActionName($event)
    {
        switch (strtolower($event)) {
            case 'created':
                return 'create';
                break;
            case 'updated':
                return 'update';
                break;
            case 'deleted':
                return 'delete';
                break;
            default:
                return 'unknown';
        }
    }
}
