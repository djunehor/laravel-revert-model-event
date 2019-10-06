<?php
/**
 * Created by PhpStorm.
 * User: Djunehor
 * Date: 10/6/2019
 * Time: 10:46 PM
 */
return [

	'user_type' => env('MODEL_EVENT_ADMIN_MODEL_TYPE', "App\\User"), //specify model name
	'user_id' => env('MODEL_EVENT_ADMIN_MODEL_ID', 1), //specify model id as int or array of IDs
];