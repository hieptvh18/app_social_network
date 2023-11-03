<?php

namespace Modules\Core\Repositories\Criteria;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchCreatedBy implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {

        if (request()->has('created_by')) {
            $created_by = request()->query('created_by');
            $model = $model->whereHas('creator.info', function ($query) use ($created_by) {
                $query->whereRaw("concat(first_name, ' ', last_name) like '%" . $created_by . "%' ");
            });
        }

        return $model;
    }
}
