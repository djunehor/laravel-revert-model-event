<?php

namespace Djunehor\EventRevert;

use Djunehor\EventRevert\Models\ModelLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RevertModelEvent extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'model:revert {--i|id=}';
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Revert specific Model Event by specifying the Log ID';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */

	public function handle() {
		$id  = $this->option( 'id' );
		$log = ModelLog::find($id);
		if(!$id) {
			$this->error('Log not found!');
			return;
		}

		$revert = model_event_revert($log);
		if(!$revert['status']) {
			$this->error($revert['message']);
			return;
		}
		$this->info("Model Event #$log->id has been reverted succesffully");
		return;
	}
}
