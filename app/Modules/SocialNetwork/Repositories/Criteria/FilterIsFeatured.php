<?php

namespace Modules\SocialNetwork\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterIsFeatured implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        if (request()->has('is_featured') ) {
            $param = strtolower(request()->query('is_featured'));
            $model = $model->where('is_featured',$param);
        }

        return $model;
    }
}
