<?php

namespace Modules\Core\Services\Admin;

use App\Services\BaseService;
use Modules\Core\Repositories\BlogTagRepository;


class BlogTagService extends BaseService
{

    public function __construct(BlogTagRepository $blogTagRepository)
    {
        $this->baseRepository = $blogTagRepository;
    }

}
