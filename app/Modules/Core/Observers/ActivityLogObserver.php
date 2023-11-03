<?php

namespace Modules\Core\Observers;

use Spatie\Activitylog\Models\Activity;
use Jenssegers\Agent\Agent;

class ActivityLogObserver
{
    //
    public function creating(Activity $activity)
    {
        $user_agent = new Agent();
        $activity->ip_address = request()->ip();
        $activity->user_agent = $user_agent->getUserAgent();
    }
}
