<?php

namespace Djunehor\EventRevert;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ModelLogController extends Controller
{
    private $actions = ['update', 'delete', 'create'];

    public function index(Request $request)
    {
        $modelLogs = ModelLog::query();
        $modelLogs = $this->applyFilters($modelLogs, $request);
        $modelLogs = $modelLogs->orderByDesc('updated_at')->paginate($request->per_page ?? 15);
        $modelActions = $this->actions;

        return view('ModelEventLogger::log-table', compact('modelLogs', 'modelActions'));
    }

    public function applyFilters(Builder $modelLogs, $request) : Builder
    {
        if ($request->created_before) {
            $modelLogs->where('created_at', '<', Carbon::parse($request->created_before));
        }
        if ($request->created_after) {
            $modelLogs->where('created_at', '>', Carbon::parse($request->created_after));
        }
        if ($request->reverted_before) {
            $modelLogs->where('reverted_at', '<', Carbon::parse($request->reverted_before));
        }
        if ($request->reverted_after) {
            $modelLogs->where('reverted_at', '>', Carbon::parse($request->reverted_after));
        }
        if ($request->action) {
            $modelLogs->where('action', $request->action);
        }

        return $modelLogs;
    }

    public function show(ModelLog $log, Request $request)
    {
        $modelLogs = ModelLog::query()
                             ->where('subject_type', $log->subject_type)
                             ->where('subject_id', $log->subject_id);

        $modelLogs = $this->applyFilters($modelLogs, $request);

        $modelLogs = $modelLogs->orderByDesc('updated_at')->paginate($request->per_page ?? 15);

        $modelActions = $this->actions;

        return view('ModelEventLogger::log-table', compact('modelLogs', 'modelActions'));
    }

    public function revert($id, Request $request)
    {
        $log = ModelLog::findOrFail($id);

        if ($log->reverted_at) {
            return response()->json(trans('ModelEventLogger::model-event-logger.messages.logRevertedAlready'), 400);
        }

        $revert = model_event_revert($log);

        if (! $revert['status']) {
            return response()->json($revert['message'], 400);
        }
        $log->revert_note = $request->revert_note;
        $log->reverted_at = now();
        $log->reverter_type = auth()->user() ? get_class($request->user()) : null;
        $log->reverter_id = auth()->id();
        $log->save();

        return response()->json(trans('ModelEventLogger::model-event-logger.messages.logRevertedSuccessfully'));
    }
}
