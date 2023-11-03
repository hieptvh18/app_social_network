<?php

namespace Modules\Core\Repositories\Criteria;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterBizapp implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        if (request()->has('bizapp')) {
            $model = $model->where('bizapp', request()->query('bizapp'));
        }

        return $model;
    }
}
