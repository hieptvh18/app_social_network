<?php

namespace Modules\Core\Services\Admin;

use App\Services\BaseService;
use Modules\Core\Repositories\FaqCategoryRepository;

class FaqCategoryService extends BaseService
{

    public function __construct(FaqCategoryRepository $repository)
    {
        $this->baseRepository = $repository;
    }
}
