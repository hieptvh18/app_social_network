<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\StoryRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\StoryRequest;

class StoryController extends Controller
{
    protected $storyRepository;

    public function __construct(StoryRepositoryInterface $storyRepository){
       $this->storyRepository = $storyRepository;
    }

    // save
    public function storeStory(StoryRequest $request){
        return $this->storyRepository->store($request);
    }

    // find by id
    public function findStory($id){
        return $this->storyRepository->findStory($id);
    }

     // get my stories
     public function fetchMyStories(){
        return $this->storyRepository->fetchMyStories();
    }

    // delete
    public function forceDeleteStory($id){
        return $this->storyRepository->forceDelete($id);
    }

    // change status is_active -> 0
    public function softDeleteStory($id){
        return $this->storyRepository->softDelete($id);
    }
}
