<?php

namespace Modules\Core\Models;

use App\Casts\UserAgent;
use App\Core\Traits\QueryBuilderCacheableTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Models\Activity;
use Jenssegers\Agent\Agent;

class ActivityLog extends Activity
{
    // use QueryBuilderCacheableTrait;

    // protected $cacheTime = 300;

    /**
     * Interact with the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function userAgent(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getUserAgent($value)
        );
    }

    protected function getUserAgent($value)
    {
        $agent = new Agent();
        $agent->setUserAgent($value);
        $browser = $agent->browser();
        $browser_version = $agent->version($browser);
        $platform = $agent->platform();
        $platform_version = $agent->version($platform);
        $data = [
            'languages' => $agent->languages(),
            'device' => $agent->device(),
            'device_type' => $agent->deviceType(),
            'platform' => $platform,
            'platform_version' => $platform_version,
            'browser' => $agent->browser(),
            'browser_version' => $browser_version
        ];
        return $data;
    }
}
