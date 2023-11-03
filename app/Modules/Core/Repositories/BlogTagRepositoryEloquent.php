<?php

namespace Modules\Core\Repositories;

use Modules\Core\Models\BlogTag;

use Modules\Core\Validators\BlogTagValidator;
use Prettus\Repository\Eloquent\BaseRepository;
use Modules\Core\Repositories\BlogTagRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Core\Repositories\Criteria\FilterIsActive;

/**
 * Class BlogTagRepositoryEloquent.
 *
 * @package namespace Modules\Core\Repositories;
 */
class BlogTagRepositoryEloquent extends BaseRepository implements BlogTagRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BlogTag::class;
    }

    /**
     * Get Searchable Fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return
            [
                "name" => 'like',
                // 'is_active'
            ];
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
