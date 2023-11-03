<?php

namespace Modules\Core\Services\Admin;

use App\Services\BaseService;
use Modules\Core\Repositories\PlanFeatureRepository;

class PlanFeatureService extends BaseService
{

    public function __construct(PlanFeatureRepository $planFeatureRepository)
    {
        $this->baseRepository = $planFeatureRepository;
    }
}
