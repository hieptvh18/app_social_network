<?php

namespace Modules\Core\Services\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Modules\Core\Repositories\MissionGiftRepository;

class MissionGiftAdminService extends BaseService
{

    public function __construct(MissionGiftRepository $missionGiftRepository)
    {
        $this->baseRepository = $missionGiftRepository;
    }

    public function getList(Request $request)
    {
        $this->limit = request()->query('size') ?? 10;
        $collection = $this->baseRepository
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $collection;
    }

}
