<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Enums\UploadTypeEnum;
use Modules\Core\Http\Requests\UploadFileRequest;
use Modules\Core\Services\UploadService;

class UploadController extends ApiController
{

    protected $uploadService;

    public function __construct(UploadService $uploadService) {
        $this->uploadService = $uploadService;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function uploadFile(UploadFileRequest $request)
    {
        $file = $this->uploadService->upload($request);
        return $this->json([
            'succes' => true,
            'file' => $file
        ]);
    }

}
