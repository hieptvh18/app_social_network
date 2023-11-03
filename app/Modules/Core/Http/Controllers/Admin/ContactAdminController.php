<?php

namespace Modules\Core\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Modules\Core\Http\Requests\ContactUpdateRequest;
use Modules\Core\Services\Admin\ContactService;


/**
 * @group Module Core
 *
 * APIs for managing endpoint core
 *
 * @subgroup Contact Management
 * @subgroupDescription ContactAdminController
 */
class ContactAdminController extends ApiController
{

    protected $contactService;
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Get List Contact
     *
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $data = $this->contactService->getList($request);
        return $this->json($data);
    }

    /**
     * Update Status Contact
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ContactUpdateRequest $request, $id)
    {
        $updated = $this->contactService->update($request, $id);
        $data = [
            'message' => __('core::message.contact.update_success'),
            'data' => $updated
        ];
        return $this->json($data);
    }

    /**
     * Find Contact
     *
     * Show the specified resource.
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $data = $this->contactService->find($id);
        return $this->json(['data' => $data]);
    }


    /**
     * Delete Contact
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $deleted = $this->contactService->delete($id);
        $data = [
            'message' => __('core::message.contact.delete_success'),
            'data' => $deleted
        ];
        return $this->json($data);
    }

}
