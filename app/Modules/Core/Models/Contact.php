<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\CoreHasUserAudit;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasUniqueCode;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Contact.
 *
 * @package namespace Modules\Core\Models;
 */
class Contact extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes, CoreHasUserAudit, CoreHasUniqueCode;

    protected $table="core_contacts";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'email',
        'message',
        'status',
        'bizapp',
        'ip_address',
        'user_agent'
    ];

}
