<?php

namespace Modules\Core\Repositories;

use Modules\Core\Models\FaqCategory;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Core\Repositories\FaqCategoryRepository;
use Modules\Core\Repositories\Criteria\FilterIsActive;

/**
 * Class FaqCategoryRepositoryEloquent.
 *
 * @package namespace Modules\Core\Repositories;
 */
class FaqCategoryRepositoryEloquent extends BaseRepository implements FaqCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FaqCategory::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterIsActive::class));
    }

}
