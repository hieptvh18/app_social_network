<?php

namespace Modules\SocialNetwork\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SocialNetwork\Http\Requests\StoryCreateRequest;
use Modules\SocialNetwork\Services\StoryService;

class StoryController extends Controller
{
    protected $storyService;

    public function __construct(StoryService $storyService){
        $this->storyService = $storyService;
    }

    /**
     * create new story
     * @param StoryCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeStory(StoryCreateRequest $request){
        return $this->storyService->store($request);
    }

    /**
     * get story by id
     * @param $id
     * @return mixed
     */
    public function findStory($id){
        return $this->storyService->findStory($id);
    }

    /**
     * get my stories
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchMyStories(){
        return $this->storyService->fetchMyStories();
    }

    /**
     * force delete
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDeleteStory($id){
        return $this->storyService->forceDelete($id);
    }

    /**
     * soft delete
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function softDeleteStory($id){
        return $this->storyService->softDelete($id);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchListStoryIsActive(){
        return $this->storyService->fetchListStoryIsActive();
    }
}
