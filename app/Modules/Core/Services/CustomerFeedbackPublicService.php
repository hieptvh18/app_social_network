<?php

namespace Modules\Core\Services;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Modules\Core\Repositories\Criteria\FilterBizappAlias;
use Modules\Core\Repositories\CustomerFeedbackRepository;


class CustomerFeedbackPublicService extends BaseService{

    public function __construct(CustomerFeedbackRepository $customerFeedbackRepository)
    {
        $this->baseRepository = $customerFeedbackRepository;
        $this->baseRepository->pushCriteria(app(FilterBizappAlias::class));
    }

    public function getList(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository->orderBy($this->sort, $this->dir);
        return $collection->paginate($this->limit);
    }
}
