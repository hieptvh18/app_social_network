<?php

namespace Modules\Core\Repositories\Criteria;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterBizappAlias implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        if (request()->has('bizapp_alias')) {
            $model = $model->where('bizapp_alias', request()->query('bizapp_alias'));
        }

        return $model;
    }
}
