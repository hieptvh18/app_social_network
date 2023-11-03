<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Modules\Core\Services\Admin\ContactService;
use Modules\Core\Http\Requests\ContactCreateRequest;

/**
 * @group Module Core
 *
 * APIs for managing contacts
 *
 * @subgroup Contact Management
 * @subgroupDescription ContactController
 */
class ContactController extends ApiController
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Send Contact
     *
     * Store a newly send resource in storage.
     * @param ContactCreateRequest $request
     * @return JsonResponse
     */
    public function store(ContactCreateRequest $request)
    {
        $created = $this->contactService->sendContact($request);
        $data = [
            'message'  => __('core::message.contact.send_contact_success'),
            'data'     => $created
        ];
        return $this->json($data);
    }

}
