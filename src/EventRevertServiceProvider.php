<?php

namespace Djunehor\EventRevert;

use Illuminate\Support\ServiceProvider;

class EventRevertServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->loadRoutesFrom(__DIR__.'routes/web.php');
		$this->loadMigrationsFrom(__DIR__.'database/migrations');
		$this->loadViewsFrom(__DIR__.'resources/views', 'modelLog');
		$this->publishes([
			__DIR__.'resources/views' => base_path('resources/views/djunehor/event-revert'),
		]);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
		$this->app->make('Djunehor\EventRevert\App\Http\Controllers\ModelLogController');
	}
}
