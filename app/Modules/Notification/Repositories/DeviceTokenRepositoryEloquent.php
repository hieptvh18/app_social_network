<?php

namespace Modules\Notification\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Notification\Repositories\DeviceTokenRepository;
use Modules\Notification\Models\DeviceToken;
use Modules\Notification\Validators\DeviceTokenValidator;

/**
 * Class DeviceTokenRepositoryEloquent.
 *
 * @package namespace Modules\Notification\Services;
 */
class DeviceTokenRepositoryEloquent extends BaseRepository implements DeviceTokenRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DeviceToken::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
