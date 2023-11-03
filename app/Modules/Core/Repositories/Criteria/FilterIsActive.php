<?php

namespace Modules\Core\Repositories\Criteria;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterIsActive implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        if (request()->has('is_active')) {
            $model = $model->where('is_active', request()->query('is_active') === 'true' ? 1 : 0);
        }

        return $model;
    }
}
