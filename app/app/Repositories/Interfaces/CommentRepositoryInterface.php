<?php
namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

Interface CommentRepositoryInterface
{

    /**
     * Fetch comment 
     */
    public function fetchComments($postId);

    /**
     * @param $request
     * post comments
     */
    public function saveComment($request);
}

?>
