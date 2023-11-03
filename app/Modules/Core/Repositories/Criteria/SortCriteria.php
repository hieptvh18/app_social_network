<?php

namespace Modules\Core\Repositories\Criteria;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SortCriteria implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        $sort = request()->query('sort', 'updated_at');
        $dir = request()->query('dir', 'DESC');
        $model = $model->orderBy($sort, $dir);

        return $model;
    }
}
