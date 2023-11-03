<?php

namespace Modules\Core\Services\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Modules\Core\Models\RewardPoint;
use Modules\Quiz\Models\RewardPointHistory;
use Illuminate\Support\Facades\Notification;
use Modules\Core\Repositories\HistoryGiftRepository;
use Modules\Core\Notifications\GiftMoneyDatabaseNotification;
use Modules\Core\Notifications\RefusedApproveUserGiftMoneyNotification;
use Modules\Core\Notifications\AdminCancelledGiftMoneyDatabaseNotification;
use Modules\Core\Notifications\UserGiftMoneyReceivedNotification;

class HistoryGiftAdminService extends BaseService
{

    public function __construct(HistoryGiftRepository $repository)
    {
        $this->baseRepository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function getList(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->where('mission_type', 'EXCHANGE_GIFT')
            ->with('creator')
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $collection;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function promotionGiftHistories(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->where('mission_type', 'REWARD')
            ->with('creator', 'missionGift')
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $collection;
    }

    public function changeStatusHistoryGift(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $history_gift = $this->baseRepository->find($id);

            $status = $request->status;
            if($status == 'RECEIVED'){
                $history_gift->received();
                $mission_gift = $history_gift->missionGift;
                $mission_gift->decrement('exchange_qty');
                $user = $history_gift->creator;
                Notification::send($user, new GiftMoneyDatabaseNotification($user, 'done_gift_money', $mission_gift, '',''));
                Notification::send($user, new UserGiftMoneyReceivedNotification($user, $mission_gift, $history_gift));
            }elseif($status == 'CANCELLED'){
                $history_gift->cancelled();
                $mission_gift = $history_gift->missionGift;
                $point = $mission_gift->exchange_point;
                $history_gift->update([
                    'reason_refuse_approve' => $request->input('reason_refuse_approve')
                ]);
                $user = $history_gift->creator;
                $user->increment('reputation', $point);
                $user_reward_point = RewardPoint::where('user_id', $user->id)->first();
                $user_reward_point->increment('reward_point', $point);
                RewardPointHistory::create([
                    'exam_id' => 0,
                    'type' => 'POINT_REFUND',
                    'reward_point' => $point,
                    'user_id' => $user->id
                ]);
                Notification::send($user, new AdminCancelledGiftMoneyDatabaseNotification($user, $mission_gift, 'cancelled-gift-money', $point));
                Notification::send($user, new RefusedApproveUserGiftMoneyNotification($user, $mission_gift, $history_gift));
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

}
