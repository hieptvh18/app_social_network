<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Bizapp.
 *
 * @package namespace Modules\Core\Models;
 */
class Bizapp extends Model implements Transformable
{
    use TransformableTrait, CoreHasUserAudit, SoftDeletes;

    protected $table = "core_bizapps";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'alias',
        'logo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

}
