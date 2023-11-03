<?php

namespace Modules\Core\Repositories\Criteria;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class MyCriteria implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        if (auth('sanctum')->user()->isAdminCrm()) {
            return $model;
        }

        $model = $model->where('created_by', '=', auth()->id());
        return $model;
    }
}
