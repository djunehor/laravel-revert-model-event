<?php
/**
 * Created by PhpStorm.
 * User: Djunehor
 * Date: 10/5/2019
 * Time: 1:27 AM
 */
namespace Djunehor\EventRevert\App\Http\Traits;
use Djunehor\EventRevert\Models\ModelLog as Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 *  Automatically Log Add, Update, Delete events of Model.
 */
trait ModelEventLogger {


	/**
	 * Automatically boot with Model, and register Events handler.
	 */

//	protected static function boot() {
//		parent::boot();
//
//		static::deleting(function ($model) {
//			// deleting listener logic
//		});
//
//		static::saving(function ($model) {
//			// saving listener logic
//		});
//
//		static::updating(function ($model) {
//			echo 'Hello';
//			Log::info($model);
//		});
//	}

	protected static function boot()
	{
		parent::boot();

		foreach (static::getRecordActivityEvents() as $eventName) {
			static::$eventName(function (Model $model) use ($eventName) {
				try {
					$reflect = new \ReflectionClass($model);
					return Activity::create([
						'causer_id'     => $request->user()->id ?? null,
						'causer_type'     => $request->user() ? get_class($request->user()) : null,
						'subject_id'   => $model->id,
						'subject_type' => get_class($model),
						'action'      => static::getActionName($eventName),
						'description' => ucfirst($eventName) . " a " . $reflect->getShortName(),
						'old'     => json_encode($model->getOriginal()),
						'new'     => json_encode($model->getDirty()),
						'route'     => (php_sapi_name() === 'cli' OR defined('STDIN')) ? null : request()->url(),
					]);
				} catch (\Exception $e) {
					Log::info($e->getMessage());

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
	 * Return Suitable action name for Supplied Event
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