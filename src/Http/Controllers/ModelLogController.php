<?php

namespace Djunehor\EventRevert\App\Http\Controllers;

use Illuminate\Http\Request;
use Djunehor\EventRevert\App\ModelLog;
use \App\Http\Controllers\Controller;

class ModelLogController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}

	public function index()
	{
		$logs = ModelLog::query()->paginate();
		return view('djunehor.event-revert.log-table', compact($logs));
	}

	public function revert(ModelLog $log)
	{
		//
		return back()->with('Query successfully reverted');
	}



}
