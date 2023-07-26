<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{

    protected $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function fetchComments($postId){
        return $this->commentRepository->fetchComments($postId);
    }

    public function saveComment(CommentRequest $request){
        return $this->commentRepository->saveComment($request);
    }

    public function delete($postId){
        return $this->commentRepository->delete($postId);
    }
}
