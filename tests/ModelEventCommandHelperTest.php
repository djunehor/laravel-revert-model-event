<?php

namespace Djunehor\EventRevert\Test;

use Djunehor\EventRevert\ModelLog;
use Illuminate\Support\Facades\Artisan;

class ModelEventCommandHelperTest extends TestCase
{
    /** @test */
    public function it_can_run_revert_command_with_id()
    {
        $model = $this->create();
        $oldName = 'Samuel';
        $model->update(['name' => 'John']);
        $event = ModelLog::query()->orderByDesc('id')->first();
        Artisan::call('model:revert --id='.$event->id);
        $newModel = $this->model::find($model->id);
        $this->assertEquals($oldName, $newModel->name);
    }

    /** @test */
    public function it_can_run_revert_command_with_i()
    {
        $model = $this->create();
        $oldName = 'Samuel';
        $model->update(['name' => 'John']);
        $event = ModelLog::query()->orderByDesc('id')->first();
        Artisan::call('model:revert -i'.$event->id);
        $newModel = $this->model::find($model->id);
        $this->assertEquals($oldName, $newModel->name);
    }

    /** @test */
    public function it_fail_on_invalid_command_with_i()
    {
        $model = $this->create();
        $model->update(['name' => 'John']);
        $event = ModelLog::query()->orderByDesc('id')->first();
        try {
            Artisan::call('model:revert -sam'.$event->id);
        } catch (\Exception $e) {
            $this->assertEquals('The "-s" option does not exist.', $e->getMessage());
        }
    }
}
