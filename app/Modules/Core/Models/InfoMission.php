<?php

namespace Modules\Core\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Affiliate\Models\Banner;
use Modules\Core\Traits\CoreHasUniqueCode;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class InfoMission.
 *
 * @package namespace Modules\Core\Models;
 */
class InfoMission extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes, CoreHasUniqueCode, CoreHasUserAudit;

    protected $table = "core_info_missions";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'assign_user_type',
        'apply_entity_type',
        'method_reward_point_type',
        'reward_point_condition_number',
        'method_approval_type',
        'reward_point',
        'expired_time_type',
        'expired_time_after',
        'is_active',
        'guilde_report_description',
        'apply_start_date',
        'apply_end_date',
        'reward_type',
        'banner_url',
        'image_url',
        'gift_id'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function mission_gift()
    {
        return $this->belongsTo(MissionGift::class, 'gift_id');
    }
}
