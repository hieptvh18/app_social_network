<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Traits\TransformableTrait;
use Modules\Core\Traits\CoreHasUserAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Traits\CoreHasLogsActivity;

/**
 * Class CustomerFeedback.
 *
 * @package namespace Modules\Core\Models;
 */
class CustomerFeedback extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes, HasFactory;
    use CoreHasUserAudit, CoreHasLogsActivity;

    protected $table = 'core_customer_feedbacks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'image_url',
        'description',
        'customer_name',
        'bizapp_alias',
        'is_active',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

}
