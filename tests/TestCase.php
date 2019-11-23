<?php

namespace Djunehor\EventRevert\Test;

use Djunehor\EventRevert\EventRevertServiceProvider;
use Djunehor\EventRevert\ModelLog;
use Djunehor\EventRevert\Test\Models\TestModel;
use Djunehor\EventRevert\Test\Models\ModelEventLogTestUser;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Encryption\Encrypter;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\Concerns\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $model;

    public function setUp(): void
    {
        parent::setUp();

        // Note: this also flushes the cache from within the migration
        $this->setUpDatabase();
        $this->setUpModel();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            EventRevertServiceProvider::class,
        ];
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('app.key', 'base64:' . base64_encode(
                Encrypter::generateKey($app['config']['app.cipher'])
            ));

        $app['config']->set('app.env', 'local');
        $app['config']->set('app.debug', true);
        $app['config']->set('auth.providers.users.model', ModelEventLogTestUser::class);
        $config = include_once  __DIR__.'/../src/config/model-event-logger.php';
        $app['config']->set('model-event-logger.user_type', ModelEventLogTestUser::class);
        $app['config']->set('model-event-logger.user_id', 1);
    }

    /**
     * Set up the database.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase()
    {
        include_once __DIR__.'/../src/database/migrations/2019_10_04_235130_create_model_logs_table.php';
        (new \CreateModelLogsTable())->up();

        Schema::create(  'test_model_table', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('city');
            $table->string('country');
            $table->timestamps();
        });

        Schema::create('test_user_table', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        ModelEventLogTestUser::query()->create([
           'name' => 'John',
           'email' => 'example@gmail.com',
           'password' => bcrypt('password')
        ]);
    }

    protected function setUpModel()
    {
        $this->model = new TestModel();
    }

    protected function create()
    {
        return $this->model::create([
            'name' => 'Samuel',
            'city' => 'Lokoja',
            'country' => 'Nigeria'
        ]) ;
    }

    public function beforeApplicationDestroyed(callable $callback)
    {
        parent::beforeApplicationDestroyed($callback); // TODO: Change the autogenerated stub
        ModelEventLogTestUser::query()->truncate();
        $this->model::truncate();
        ModelLog::query()->truncate();
    }
}
