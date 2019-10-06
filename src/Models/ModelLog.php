<?php

namespace Djunehor\EventRevert\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelLog extends Model
{
	protected $fillable = [
		'causer_id',
		'causer_type',
		'subject_id',
		'subject_type',
		'action',
		'description',
		'old',
		'new',
		'route'
	];
    use SoftDeletes;

    public function subject() {
    	return $this->morphTo('subject');
    }

	public function causer() {
		return $this->morphTo('causer');
	}

	public function reverter() {
		return $this->morphTo('reverter');
	}
}
