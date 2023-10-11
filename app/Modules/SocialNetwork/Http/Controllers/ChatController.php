<?php

namespace Modules\SocialNetwork\Http\Controllers;

use Modules\SocialNetwork\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function fetchMessage($reciever){
        return $this->chatService->fetchMessage($reciever);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function saveMessage(Request $request){
        return $this->chatService->saveMessage($request);
    }
}
