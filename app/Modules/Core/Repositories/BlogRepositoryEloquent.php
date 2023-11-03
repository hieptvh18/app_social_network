<?php

namespace Modules\Core\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Core\Repositories\BlogRepository;
use Modules\Core\Models\Blog;
use Modules\Core\Repositories\Criteria\FilterStatus;
use Modules\Core\Repositories\Criteria\SearchCreatedBy;
use Modules\Core\Validators\BlogValidator;

/**
 * Class BlogRepositoryEloquent.
 *
 * @package namespace Modules\Core\Repositories;
 */
class BlogRepositoryEloquent extends BaseRepository implements BlogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Blog::class;
    }


    /**
     * Get Searchable Fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        $locale = config('app.locale');
        return
            [
                "name->$locale" => 'like',
                'code'  => 'like',
                'alias'  => 'like',
                // 'is_active'
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterStatus::class));
        $this->pushCriteria(app(SearchCreatedBy::class));
    }

}
