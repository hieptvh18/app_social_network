<?php

namespace Modules\Core\Services;

use Exception;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Modules\Core\Repositories\HistoryGiftRepository;

class HistoryGiftService extends BaseService
{

    public function __construct(HistoryGiftRepository $historyGiftRepository)
    {
        $this->baseRepository = $historyGiftRepository;
    }

    public function getList(Request $request)
    {
        $user_id = auth()->id();
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository->with(['missionGift'])
            ->where(['created_by' => $user_id, 'status' => 'RECEIVED'])
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $collection;
    }

}
