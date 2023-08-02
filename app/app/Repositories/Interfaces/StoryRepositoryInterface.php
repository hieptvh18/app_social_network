<?php
namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

Interface StoryRepositoryInterface{

    /**
     * Save story
     */
    public function store(Request $request);

    /**
     * get all story by friend
     */
    public function fetchStoryByFriend();

    /**
     * get story by id
     */
    public function findStory($id);

    /**
     * get list my story
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
