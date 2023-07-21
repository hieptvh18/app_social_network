<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ChatRepositoryInterface;

class ChatController extends Controller
{

    protected $chatRepository;

    public function __construct(ChatRepositoryInterface $chatRepositoryInterface)
    {
        $this->chatRepository = $chatRepositoryInterface;
    }

    public function saveMessage(Request $request){
        return $this->chatRepository->saveMessage($request);
    }

    public function fetchMessage($reciever){
        return $this->chatRepository->fetchMessage($reciever);
    }
}
