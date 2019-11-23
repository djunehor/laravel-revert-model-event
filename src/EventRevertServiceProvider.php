<?php

namespace Djunehor\EventRevert;

use Illuminate\Support\ServiceProvider as MyServiceProvider;

class EventRevertServiceProvider extends MyServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'ModelEventLogger');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'ModelEventLogger');

        $this->publishFiles();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['router']->aliasMiddleware('model-event-logger-middleware', ModelEventLogMiddleware::class);
        $this->commands([
            RevertModelEvent::class,
        ]);
    }

    private function publishFiles()
    {
        $publishTag = 'ModelEventLogger';

        $this->publishes([
            __DIR__.'/resources/views' => base_path('resources/views/vendor/'.$publishTag),
        ], $publishTag);
        $this->publishes([
            __DIR__.'/resources/lang' => base_path('resources/lang/vendor/'.$publishTag),
        ], $publishTag);
        $this->publishes([
            __DIR__.'/config/model-event-logger.php' => config_path('model-event-logger.php'),
        ], $publishTag);
    }
}
