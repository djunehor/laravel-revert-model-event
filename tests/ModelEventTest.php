<?php

namespace Djunehor\EventRevert\Test;

use Djunehor\EventRevert\ModelLog;
use Illuminate\Support\Facades\Artisan;

class ModelEventTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_detects_model_create_event()
    {
        $this->create();
        $event = ModelLog::query()->first();
        $this->assertNotNull($event);
        $this->assertEquals('create', $event->action);
    }

    /** @test */
    public function it_detects_model_delete_event()
    {
        $model = $this->create()->delete();
        $event = ModelLog::query()->orderByDesc('id')->first();
        $this->assertNotNull($event);
        $this->assertEquals('delete', $event->action);
    }

    /** @test */
    public function it_detects_model_update_event()
    {
        $model = $this->create()->update(['name' => 'John']);
        $event = ModelLog::query()->orderByDesc('id')->first();
        $this->assertNotNull($event);
        $this->assertEquals('update', $event->action);
    }

    /** @test */
    public function it_can_run_revert_command()
    {
        $model = $this->create();
        $oldName = 'Samuel';
        $model->update(['name' => 'John']);
        $event = ModelLog::query()->orderByDesc('id')->first();
        Artisan::call('model:revert --id='.$event->id);
        $newModel = $this->model::find($model->id);
        $this->assertEquals($oldName, $newModel->name);
    }
}
