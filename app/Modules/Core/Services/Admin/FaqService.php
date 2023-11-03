<?php

namespace Modules\Core\Services\Admin;

use Illuminate\Http\Request;
use App\Services\BaseService;
use Modules\Core\Repositories\FaqRepository;

class FaqService extends BaseService
{

    public function __construct(FaqRepository $repository)
    {
        $this->baseRepository = $repository;
    }

   public function getList(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository->with('category')
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $collection;
    }

}
