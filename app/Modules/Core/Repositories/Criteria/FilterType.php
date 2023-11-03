<?php

namespace Modules\Core\Repositories\Criteria;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterType implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        if (request()->has('type')) {
            $model = $model->where('type', request()->query('type'));
        }

        return $model;
    }
}
