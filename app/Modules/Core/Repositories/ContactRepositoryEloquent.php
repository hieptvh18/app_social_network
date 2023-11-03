<?php

namespace Modules\Core\Repositories;

use Modules\Core\Models\Contact;
use Modules\Core\Validators\ContactValidator;
use Prettus\Repository\Eloquent\BaseRepository;
use Modules\Core\Repositories\ContactRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Core\Repositories\Criteria\FilterCreatedAtCriteria;

/**
 * Class ContactRepositoryEloquent.
 *
 * @package namespace Modules\Core\Repositories;
 */
class ContactRepositoryEloquent extends BaseRepository implements ContactRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contact::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterCreatedAtCriteria::class));
    }

}
