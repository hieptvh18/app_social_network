<?php
namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

Interface StoryRepositoryInterface{

    /**
     * Save story
     */
    public function store(Request $request);

    /**
     * get all story by friend and me when story is active(24h)
     */
    public function fetchListStoryIsActive();

    /**
     * get story by id
     */
    public function findStory($id);

    /**
     * get all my story
     */
    public function fetchMyStories();

    /**
     * force delete
     */
    public function forceDelete($id);

    /**
     * soft delete
     */
    public function softDelete($id);
}

?>
