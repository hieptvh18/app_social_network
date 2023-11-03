<?php

namespace Modules\Core\Services;

use App\Services\BaseService;
use Exception;
use Modules\Core\Repositories\FaqCategoryRepository;

class FaqCategoryService extends BaseService
{

    public function __construct(FaqCategoryRepository $repository)
    {
        $this->baseRepository = $repository;
    }

    public function getFaqCate()
    {
        try {
            $data = $this->baseRepository->where('is_active', true)->get();
            return $data;
        } catch (Exception $e) {
            return $e;
        }
    }
    public function getFaqByCate($id)
    {
        try {
            $faqCate = $this->baseRepository->find($id);
            $data = $faqCate->faqs()->where('is_active', true)->get();
            return $data;
        } catch (Exception $e) {
            return $e;
        }
    }
}
