<?php

namespace Modules\Core\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Core\Repositories\BlogCategoryRepository;
use Modules\Core\Models\BlogCategory;
use Modules\Core\Repositories\Criteria\FilterIsActive;
use Modules\Core\Validators\BlogCategoryValidator;

/**
 * Class BlogCategoryRepositoryEloquent.
 *
 * @package namespace Modules\Core\Repositories;
 */
class BlogCategoryRepositoryEloquent extends BaseRepository implements BlogCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BlogCategory::class;
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
