<?php

namespace Modules\Core\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Core\Services\Admin\CacheService;

class AdminCacheController extends ApiController
{
    protected $adminCacheService;
    public function __construct(CacheService $adminCacheService)
    {
        $this->adminCacheService = $adminCacheService;
    }

     /**
     * Admin list cache option
     *
     * Display a listing of the resource.
     * @return Renderable
     */
    public function cacheOptions(Request $request){

        $data = $this->adminCacheService->cacheOptions($request);
        return $this->json(['data' => $data]);
    }

     /**
     * Admin clear cache by option
     *
     * Display a listing of the resource.
     * @return Renderable
     */
    public function clearCacheByOption(Request $request){

        $data = $this->adminCacheService->clearCacheByOption($request);
        return $this->json(['data' => $data]);
    }

    /**
     * Admin flush all cache
     * Display a listing of the resource.
     * @return Renderable
     */
    public function flush()
    {
        Cache::flush();
        return $this->json(['success' => true]);
    }
}
