<?php

namespace Modules\Core\Repositories;

use Modules\Core\Repositories\Criteria\FilterIsActive;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Core\Repositories\CustomerFeedbackRepository;
use Modules\Core\Models\CustomerFeedback;
use Modules\Core\Validators\CustomerFeedbackValidator;

/**
 * Class CustomerFeedbackRepositoryEloquent.
 *
 * @package namespace Modules\Core\Repositories;
 */
class CustomerFeedbackRepositoryEloquent extends BaseRepository implements CustomerFeedbackRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CustomerFeedback::class;
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
                'customer_name'  => 'like',
                'bizapp_alias'  => 'like',
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
