<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Modules\Core\Services\HistoryGiftService;
use Modules\Core\Http\Requests\HistoryGiftCreateRequest;

/**
 * @group Module Core
 *
 * APIs for managing endpoint core
 *
 * @subgroup History Gift Management
 * @subgroupDescription HistoryGiftController
 */
class HistoryGiftController extends ApiController
{

    protected $historyGiftService;
    public function __construct(HistoryGiftService $historyGiftService)
    {
        $this->historyGiftService = $historyGiftService;
    }
    /**
     * Danh sách quà đã nhận
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->historyGiftService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * Tạo lịch sử đổi quà
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(HistoryGiftCreateRequest $request)
    {
        $item = $this->historyGiftService->create($request);
        $data = [
            'data' => true
        ];
        return $this->json($data);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
