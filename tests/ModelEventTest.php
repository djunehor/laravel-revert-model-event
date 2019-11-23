<?php
namespace Djunehor\EventRevert\Test;

use Djunehor\EventRevert\ModelLog;

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
        ModelLog::query()->truncate();
    }

    /** @test */
    public function it_detects_model_delete_event()
    {
        $model = $this->create()->delete();
        $event = ModelLog::query()->orderByDesc('id')->first();
        $this->assertNotNull($event);
        $this->assertEquals('delete', $event->action);
        $this->model::truncate();
        ModelLog::query()->truncate();
    }

    /** @test */
    public function it_detects_model_update_event()
    {
        $model = $this->create()->update(['name' => 'John']);
        $event = ModelLog::query()->orderByDesc('id')->first();
        $this->assertNotNull($event);
        $this->assertEquals('update', $event->action);
        $this->model::truncate();
        ModelLog::query()->truncate();
    }

}
