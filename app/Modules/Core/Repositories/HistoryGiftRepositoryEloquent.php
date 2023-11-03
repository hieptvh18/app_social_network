<?php

namespace Modules\Core\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Core\Repositories\HistoryGiftRepository;
use Modules\Core\Models\HistoryGift;
use Modules\Core\Validators\HistoryGiftValidator;

/**
 * Class HistoryGiftRepositoryEloquent.
 *
 * @package namespace Modules\Core\Repositories;
 */
class HistoryGiftRepositoryEloquent extends BaseRepository implements HistoryGiftRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return HistoryGift::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
