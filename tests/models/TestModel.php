<?php

namespace Djunehor\EventRevert\Test\Models;

use Djunehor\EventRevert\ModelEventLogger;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    use ModelEventLogger;

    protected $table = 'test_model_table';

    protected $fillable = [
        'name',
        'city',
        'country',
    ];
}
