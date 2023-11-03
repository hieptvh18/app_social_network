<?php

namespace Modules\Core\Repositories\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterCreatedAtCriteria implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        $startDate = request()->query('start_date');
        $endDate = request()->query('end_date');
        if ($startDate && $endDate) {
            $model = $model->whereBetween('created_at', [$startDate, $endDate]);
        }

        return $model;
    }
}
