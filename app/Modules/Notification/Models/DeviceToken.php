<?php

namespace Modules\Notification\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class DeviceToken.
 *
 * @package namespace Modules\Notification\Models;
 */
class DeviceToken extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'notification_device_tokens';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['uuid', 'token', 'user_id', 'bizapp_alias', 'ip_address', 'user_agent'];
}
