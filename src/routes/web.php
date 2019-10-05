<?php

/**
 * Here is where you can register web routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * contains the "web" middleware group. Now create something great!
 *
 * @category Worketic
 *
 * @package Worketic
 * @author  Amentotech <theamentotech@gmail.com>
 * @license http://www.amentotech.com amentotech
 * @link    http://www.amentotech.com
 */

Route::get('/model-events', 'Djunehor\EventRevert\App\Http\Controllers\ModelLogController@index');