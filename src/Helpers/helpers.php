<?php
/**
 * Created by PhpStorm.
 * User: Djunehor
 * Date: 10/6/2019
 * Time: 1:41 AM
 */

if (!function_exists('model_event_revert')) {

	function model_event_revert( $log ): bool {
		try {
			switch ( $log->action ) {
				case 'update':
					$data  = json_decode( $log->old, true );
					$model = $log->subject;
					if ( ! $model ) {
						$response['message'] = trans( 'ModelEventLogger::model-event-logger.messages.modelNotExist' );
						$response['status']  = false;
					}
					$model->update( $data );
					break;
				case 'create':
					$log->subject()->delete();
					$response['status'] = true;
					break;
				case 'delete':
					$log->subject()->insert( json_decode( $log->old, true ) );
					$response['status'] = true;
					break;
				default:
					$response['status']  = false;
					$response['message'] = trans( 'ModelEventLogger::model-event-logger.messages.unknownModelEvent' );
			}
		} catch (\Exception $e) {
			$response['status'] = false;
			$response['message'] = 'An error occured. Please check the logs.';

			\Illuminate\Support\Facades\Log::info($e->getMessage());
		}

		return $response;
	}
}