<?php

namespace Djunehor\EventRevert;

use Closure;

class ModelEventLogMiddleware
{
    public function handle($request, Closure $next)
    {
        $userType = config('model-event-logger.user_type');
        $userIds = explode(",", config('model-event-logger.user_id'));

        if(!auth()->check() || !(
                get_class(auth()->user()) == $userType
                && in_array(auth()->id(), $userIds)
            )) {
            abort(403, "You're not authorised to perform this action");
        }

        return $next($request);
    }

}
