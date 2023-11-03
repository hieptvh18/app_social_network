<?php

namespace Modules\Core\Services;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Exceptions\ApiException;
use Modules\Core\Models\Promotion;
use Modules\Core\Models\InfoMission;
use Modules\Core\Models\UserMission;
use Illuminate\Support\Facades\Notification;
use Modules\Core\Repositories\InfoMissionRepository;
use Modules\Core\Notifications\UserDatabaseNotification;

class PromotionService extends BaseService
{

    public function __construct(InfoMissionRepository $infoMissionRepository)
    {
        $this->baseRepository = $infoMissionRepository;
    }

    public function getListPromotion(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $promotions = $this->baseRepository
            ->with('mission_gift')
            ->where([
                ['assign_user_type', 'PROMOTION'],
                ['is_active', true],
                ['apply_start_date', '<', Carbon::now()],
                ['apply_end_date', '>', Carbon::now()]
            ])
            ->orWhere([
                ['assign_user_type', 'PROMOTION'],
                ['is_active', true],
                ['apply_start_date', '<', Carbon::now()],
                ['apply_end_date', null]
            ])
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $promotions;
    }

    public function find($id)
    {
        $user = auth('sanctum')->user();
        $item = $this->baseRepository->find($id)->load('mission_gift');
        if ($user) {
            $user_mission_promotion = $user->user_missions->where(
                'info_mission_id', $id,
            )->first();
            if ($user_mission_promotion) {
                $item['has_promotion'] = true;
                $item['user_mission_promotion'] = $user_mission_promotion;
            } else {
                $item['has_promotion'] = false;
            }
        }

        return $item;
    }

    public function joinPromotion($id)
    {
        $user = auth()->user();
        $info_mission_fields = ['name', 'description', 'assign_user_type', 'apply_entity_type', 'method_reward_point_type', 'reward_point_condition_number', 'method_approval_type', 'reward_point', 'expired_time_type', 'expired_time_after', 'guilde_report_description', 'apply_start_date', 'apply_end_date', 'reward_type', 'gift_id'];
        $info_mission = InfoMission::select($info_mission_fields)->where([
            ['id', $id],
            ['assign_user_type', 'PROMOTION'],
            ['apply_entity_type', 'USER'],
            ['is_active', true],
            ['apply_start_date', '<=', Carbon::now()],
            ['apply_end_date', '>=', Carbon::now()]
        ])
            ->orWhere([
                ['id', $id],
                ['assign_user_type', 'PROMOTION'],
                ['apply_entity_type', 'USER'],
                ['is_active', true],
                ['apply_start_date', '<=', Carbon::now()],
                ['apply_end_date', null]
            ])
            ->firstOrFail();


        $user_mission = new UserMission();
        $finished_time = null;
        if ($info_mission->expired_time_after !== null) {
            if ($info_mission->expired_time_type === 'DAY') {
                $day = $info_mission->expired_time_after;
                $finished_time = Carbon::now()->addDays($day);
            }
            if ($info_mission->expired_time_type === 'HOUR') {
                $hour = $info_mission->expired_time_after;
                $finished_time = Carbon::now()->addHours($hour);
            }
            if ($info_mission->expired_time_type === 'MINUTE') {
                $minute = $info_mission->expired_time_after;
                $finished_time = Carbon::now()->addMinutes($minute);
            }
        } else {
            $finished_time = null;
        }
        $info_mission = $info_mission->toArray();

        unset($info_mission['apply_start_date']);
        unset($info_mission['apply_end_date']);

        $user_mission->forceFill(array_merge($info_mission, [
            'user_id' => $user->id,
            'info_mission_id' => $id,
            'entity_typeable_id' => 0,
            'entity_typeable_type' => 'Quiz/Promotion',
            'finished_time' => $finished_time,
            'status' => 'DOING',
            'created_at' => now()
        ]))->save();

        $admins = User::whereHas('info', function($query){
            $query->where('type', 'ADMIN');
        })->get();

        Notification::send($admins, new UserDatabaseNotification($user, 'joined-promotion', $info_mission['name']));

        return true;
    }
}
