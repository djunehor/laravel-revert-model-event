<?php

/**
 * Here is where you can register web routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * contains the "web" middleware group. Now create something great!
 */
Route::group(['namespace' => 'Djunehor\EventRevert', 'middleware' => ['web', 'model-event-logger-middleware']], function () {
    Route::get('/model-events', 'ModelLogController@index');
    Route::get('/model-events/{log}', 'ModelLogController@show');
    Route::patch('/model-event-revert/{id}', 'ModelLogController@revert');
});
