<?php
namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

Interface PostRepositoryInterface{

    public function getPostByFollowingId();

    public function save($request);
}

?>
