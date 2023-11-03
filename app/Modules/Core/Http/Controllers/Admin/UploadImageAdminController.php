<?php

namespace Modules\Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Modules\Core\Http\Requests\BlogCreateRequest;
use Modules\Core\Http\Requests\BlogUpdateRequest;
use Modules\Core\Http\Requests\UploadFileRequest;
use Modules\Core\Services\Admin\UploadImageService;

/**
 * @group Module Core
 *
 * APIs for managing endpoint core
 *
 * @subgroup Admin Upload image management
 * @subgroupDescription UploadImageAdminController
 */
class UploadImageAdminController extends ApiController
{

    protected $uploadImageService;
    public function __construct(UploadImageService $uploadImageService)
    {
        $this->uploadImageService = $uploadImageService;
    }
    /**
     * Upload image
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function uploadImage(UploadFileRequest $request)
    {
        $file = $this->uploadImageService->uploadImage($request);
        return $this->json([
            'succes' => true,
            'file' => $file
        ]);
    }
}
