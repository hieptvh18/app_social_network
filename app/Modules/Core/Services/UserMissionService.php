<?php

namespace Modules\Core\Services;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Modules\Quiz\Models\Exam;
use Illuminate\Support\Facades\DB;
use Modules\Core\Models\UserMission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use Modules\Core\Repositories\UserMissionRepository;
use Modules\Core\Notifications\UserDatabaseNotification;

class UserMissionService extends BaseService
{

    public function __construct(UserMissionRepository $userMissionRepository)
    {
        $this->baseRepository = $userMissionRepository;
    }

    public function getList(Request $request)
    {
        $user_id = auth()->id();
        $exam_id = request()->query('exam_id');
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository->with(['entity_typeable'])
            ->where('user_id', $user_id);

        if ($exam_id) {
            $collection = $collection
                ->where('entity_typeable_id', $exam_id);
        }
        $collection = $collection->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $collection;
    }

    public function reportMissionUser(Request $request)
    {
        try {
            $user = auth()->user();
            $user_mission_id = $request->input('user_mission_id');

            $report_result = $request->input('report_result');
            $report_result_des_promotion =  $request->input('report_result.description');
            $report_result_img_promotion = $request->input('report_result.image_url');

            $user_mission = $this->baseRepository->where([
                ['status', '<>', 'EXPIRED'],
                ['id', $user_mission_id]
            ])
                ->firstOrFail();
            $user_type = $user_mission->assign_user_type;
            if ($user_type == 'PROMOTION') {
                $images_promotion_report_tmp = Storage::disk('s3')->allFiles('promotion_report_tmp');
                $image_url = '';
                foreach ($images_promotion_report_tmp as $image_promotion_report_tmp) {
                    if ($report_result_img_promotion === $image_promotion_report_tmp) {
                        $image_url = str_replace('promotion_report_tmp', 'promotion_report', $image_promotion_report_tmp);
                        Storage::disk('s3')->move($image_promotion_report_tmp, $image_url);
                        Storage::disk('s3')->deleteDirectory('promotion_report_tmp');
                    }
                };
                $report_result = [
                    'description' => $report_result_des_promotion,
                    'image_url' => $image_url
                ];
            }


            DB::beginTransaction();
            $user_mission->report_result = $report_result;
            $user_mission->save();
            $user_mission->waitingApprove();
            DB::commit();
            $admins = User::whereHas('info', function($query){
                $query->where('type', 'ADMIN');
            })->get();

            Notification::send($admins, new UserDatabaseNotification($user, 'reported', $user_mission->name));
            $data = [
                'success' => true,
                'mission_status' => $user_mission->status
            ];
            return $data;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
