<?php

namespace Djunehor\EventRevert;

use Closure;

class ModelEventLogMiddleware
{
    public function handle($request, Closure $next)
    {
        $userIds = explode(',', config('model-event-logger.user_id'));
        $guard = config('model-event-logger.guard');

        if (! auth($guard)->check() || ! in_array(auth($guard)->id(), $userIds)) {
            abort(403, "You're not authorised to perform this action");
        }

        return $next($request);
    }
}
