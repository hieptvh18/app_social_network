<?php

namespace Modules\SocialNetwork\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SocialNetwork\Http\Requests\CommentCreateRequest;
use Modules\SocialNetwork\Services\CommentService;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function fetchComments($postId){
        return $this->commentService->fetchComments($postId);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function saveComment(CommentCreateRequest $request){
        return $this->commentService->saveComment($request);
    }

    /**
     * Delete
     * @return Response
     */
    public function delete($id){
        return $this->commentService->delete($id);
    }
}
