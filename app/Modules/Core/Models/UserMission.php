<?php

namespace Modules\Core\Models;

use App\Exceptions\ApiException;
use App\Gamify\Points\PointExamMission;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Enums\UserMissionStatusEnum;
use Modules\Core\Events\UserMissionDoneEvent;
use Modules\Core\Traits\CoreHasUserAudit;
use Modules\Core\Traits\CoreHasUniqueCode;
use Modules\Quiz\Models\Exam;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class UserMission.
 *
 * @package namespace Modules\Core\Models;
 */
class UserMission extends Model implements Transformable
{
    use TransformableTrait, CoreHasUserAudit, CoreHasUniqueCode;

    protected $table = "core_user_missions";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
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
        'finished_time',
        'report_result',
        'status',
        'percent_complete',
        'reward_type',
        'gift_id',
        'reason_refuse_approve'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'report_result' => 'json'
    ];

    public function entity_typeable()
    {
        return $this->morphTo('entity_typeable', Exam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function info()
    {
        return $this->belongsTo(InfoMission::class, 'info_mission_id');
    }

    public function historyGift()
    {
        return $this->hasMany(HistoryGift::class, 'user_id');
    }

    public function mission_gift()
    {
        return $this->belongsTo(MissionGift::class, 'gift_id');
    }


    /**
     * Change status to done .
     *
     * @return $this
     */
    public function done()
    {
        $this->update(['status' => 'DONE']);
        event(new UserMissionDoneEvent($this));
        return $this;
    }

    /**
     * Change status to waiting approve .
     *
     * @return $this
     */
    public function waitingApprove()
    {
        $this->update(['status' => 'WAITING_FOR_APPROVE']);

        return $this;
    }

    /**
     * Change status to expired .
     *
     * @return $this
     */
    public function expired()
    {
        $this->update(['status' => 'EXPIRED']);

        return $this;
    }

     /**
     * Change status to refused approval .
     *
     * @return $this
     */
    public function refusedApprove()
    {
        $this->update(['status' => 'REFUSED_APPROVE']);

        return $this;
    }
}
