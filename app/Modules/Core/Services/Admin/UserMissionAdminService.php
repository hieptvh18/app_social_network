<?php

namespace Modules\Core\Services\Admin;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Modules\Core\Models\HistoryGift;
use Illuminate\Support\Facades\Notification;
use Modules\Core\Notifications\NotifyRefusedApprove;
use Modules\Core\Repositories\UserMissionRepository;

class UserMissionAdminService extends BaseService
{

    public function __construct(UserMissionRepository $userMissionRepository)
    {
        $this->baseRepository = $userMissionRepository;
    }

    public function getList(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $assign_user_type = request()->query('assign_user_type');
        $collection = $this->baseRepository->with(['user', 'entity_typeable'])
            ->orderBy($this->sort, $this->dir);
        if ($assign_user_type) {
            $collection = $collection->where('assign_user_type', $assign_user_type);
        }
        return $collection->paginate($this->limit);
    }

    public function approveMission(Request $request)
    {
        try {
            $user_mission_id = $request->input('user_mission_id');
            $user_mission = $this->baseRepository->where([
                'id' => $user_mission_id,
                'method_approval_type' => 'MANUAL',
                'status' => 'WAITING_FOR_APPROVE'
            ])->firstOrFail();
            $user_join_id = $user_mission->user->id;
            DB::beginTransaction();
            $user_mission->done();
            $info_mission = $user_mission->info;
            if ($user_mission->assign_user_type === 'PROMOTION') {
                HistoryGift::create([
                    'gift_id' => $user_mission->gift_id ?? null,
                    'gift_result' => $info_mission,
                    'mission_type' => 'REWARD',
                    'created_by' => $user_join_id,
                    'updated_by' => $user_join_id,
                ]);
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }


        // if ($exam_mission) {
        //     $exam = Exam::find($user_mission->entity_typeable_id);



        //     if ($user_mission->method_reward_point_type === 'VIEWED') {
        //         $user->givePoint(new ExamViewed($exam, $user_mission->reward_point));
        //     }

        //     if ($user_mission->method_reward_point_type === 'DOWNLOAD') {
        //         $user->givePoint(new ExamDownload($exam, $user_mission->reward_point));
        //     }
        // }
    }

    public function refusedApproveMission(Request $request)
    {
        try {
            $user_mission_id = $request->input('user_mission_id');
            $reason_refuse_approve = $request->input('reason_refuse_approve');
            $user_mission = $this->baseRepository->where([
                'id' => $user_mission_id,
                'method_approval_type' => 'MANUAL',
                'status' => 'WAITING_FOR_APPROVE'
            ])->firstOrFail();
            DB::beginTransaction();
            $user_mission->refusedApprove();
            $user_mission->update([
                'reason_refuse_approve' => $reason_refuse_approve
            ]);
            DB::commit();
            Notification::send($user_mission->user, new NotifyRefusedApprove($user_mission));

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
