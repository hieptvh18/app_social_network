<?php

namespace Modules\Core\Services;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Exceptions\ApiException;
use Modules\Core\Models\HistoryGift;
use Modules\Core\Models\RewardPoint;
use Illuminate\Support\Facades\Notification;
use Modules\Core\Events\UserDoneGiftExchangeEvent;
use Modules\Core\Repositories\MissionGiftRepository;
use Modules\Core\Notifications\UserGiftMoneyNotification;
use Modules\Core\Notifications\GiftMoneyDatabaseNotification;

class MissionGiftPublicService extends BaseService
{

    public function __construct(MissionGiftRepository $missionGiftRepository)
    {
        $this->baseRepository = $missionGiftRepository;
    }

    public function getList(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository->withCount(['histories as gift_money_pending' => function ($q) {
            $q->where([
                ['created_by', auth('sanctum')->id()],
                ['status', 'PENDING']
            ])->whereHas('missionGift', function($que){
                $que->where('type', 'MONEY');
            });
        }])
            ->withCount([
                'histories as user_has_exchanged' => function ($query) {
                    $query->where([['created_by', auth('sanctum')->id()], ['status', 'RECEIVED']]);
                }
            ])
            ->where([
                ['is_active', true],
                ['apply_start_date', '<', Carbon::now()->format('Y-m-d h:i:s')],
                ['apply_end_date', '>', Carbon::now()->format('Y-m-d h:i:s')]
            ])
            ->orWhere([
                ['is_active', true],
                ['apply_start_date', '<', Carbon::now()->format('Y-m-d h:i:s')],
                ['apply_end_date', null]
            ])
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $collection;
    }

    public function userGiftExchange(Request $request)
    {
        $user = auth()->user();
        $mission_gift_id = $request->input('mission_gift_id');
        $mission_gift = $this->baseRepository->where([
            ['id', $mission_gift_id],
            ['is_active', true],
            ['apply_start_date', '<', Carbon::now()],
            ['apply_end_date', '>', Carbon::now()]
        ])
            ->orWhere([
                ['id', $mission_gift_id],
                ['is_active', true],
                ['apply_start_date', '<', Carbon::now()],
                ['apply_end_date', null]
            ])->firstOrFail();

        $user_reward_point = RewardPoint::select('reward_point')->where('user_id', $user->id)->first();
        $user_point = $user_reward_point->reward_point;

        if ($user_point < $mission_gift->exchange_point) {
            throw new ApiException('Bạn chưa đủ điểm để đổi thưởng!', 500);
        }
        if ($mission_gift->exchange_qty == 0) {
            throw new ApiException('Số lượng quà đã hết!', 500);
        }
        if (!$mission_gift->allow_exchange_many) {
            $history_gift = HistoryGift::where([['gift_id', $mission_gift_id], ['created_by', $user->id], ['status', 'RECEIVED']])->first();
            if ($history_gift) {
                throw new ApiException('Phần quà này chỉ được đổi 1 lần', 500);
            }
        }
        $status = 'RECEIVED';
        // $mission_gift->decrement('exchange_qty');

        $data = [
            'user' => $user,
            'mission_gift' => $mission_gift,
        ];
        event(new UserDoneGiftExchangeEvent($data));
        if ($mission_gift->type == 'MONEY') {
            $status = 'PENDING';
            $method_receive = $request->input('method_receive');
            if ($method_receive == 'MOMO') {
                $mobile = $request->input('mobile');
                $info_method_receive = $mobile;
            }

            $admins = User::whereHas('info', function ($query) {
                $query->where('type', 'ADMIN');
            })->get();

            Notification::send($admins, new GiftMoneyDatabaseNotification($user, 'gift-money', $mission_gift, $info_method_receive, $method_receive));
            Notification::send($admins, new UserGiftMoneyNotification($user, $mission_gift, $info_method_receive, $method_receive));
        }
        $mission_gift->histories()->create([
            'gift_result' => $mission_gift,
            'status' => $status
        ]);

        return $data;
    }
}
