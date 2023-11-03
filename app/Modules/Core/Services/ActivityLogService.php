<?php

namespace Modules\Core\Services;

use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Carbon;
use Modules\Core\Repositories\ActivityLogRepositoryEloquent;

class ActivityLogService extends BaseService
{

    public function __construct(ActivityLogRepositoryEloquent $repository)
    {
        $this->baseRepository = $repository;
    }

    public function getList(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->where('log_name', 'exam')
            ->whereDate('created_at', Carbon::now())
            ->with(['causer', 'subject'])
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $collection;
    }
}
