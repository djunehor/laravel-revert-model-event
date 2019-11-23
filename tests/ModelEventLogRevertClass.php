<?php

namespace Djunehor\EventRevert\Test;

use Djunehor\EventRevert\ModelLog;

class ModelEventLogRevertClass extends TestCase
{
    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    /** @test */
    public function it_can_revert_model_create_event()
    {
        $model = $this->create();
        $lastLog = ModelLog::query()->orderByDesc('id')->first();
        model_event_revert($lastLog);
        $newModel = $this->model::find($model->id);
        $this->assertNull($newModel);
    }

    /** @test */
    public function it_can_revert_model_update_event()
    {
        $model = $this->create();
        $oldName = $model->name;
        $model->update(['name' => 'isabel']);

        $lastLog = ModelLog::query()->orderByDesc('id')->first();
        model_event_revert($lastLog);
        $newModel = $this->model::find($model->id);
        $this->assertEquals($oldName, $newModel->name);
    }

    /** @test */
    public function it_can_revert_model_delete_event()
    {
        $model = $this->create();
        $oldName = $model->name;
        $model->delete();

        $lastLog = ModelLog::query()->orderByDesc('id')->first();
        model_event_revert($lastLog);
        $newModel = $this->model::find($model->id);
        $this->assertNotNull($newModel);
        $this->assertSame($newModel->name, $oldName);
    }

    /** @test */
    public function it_fail_on_unrecognized_model_event()
    {
        $lastLog = new \StdClass();
        $lastLog->action = 'random_action';
        $response = model_event_revert($lastLog);
        $expectedResponse = [
            'status' => false,
            'message' => 'Unknown model event encountered!'
        ];
        $this->assertSame($response, $expectedResponse);
    }

    /** @test */
    public function it_fail_on_no_model()
    {
        $lastLog = new \StdClass();
        $lastLog->action = 'create';
        $response = model_event_revert($lastLog);
        $expectedResponse = [
            'status' => false,
            'message' => 'An error occurred. Please check the logs.'
        ];
        $this->assertSame($response, $expectedResponse);
    }
}
