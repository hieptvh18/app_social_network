<?php
namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

Interface UserRepositoryInterface{

    /**
     * get user by username
     * @param mixed $username
     * @return object
     */
    public function getUserByUsername($username);

        /**
     * get user by id
     * @param mixed $id
     * @return object
     */
    public function getUserById($id);

    /**
     * get list user followed
     * @return object
     */
    public function getUserFollowing();

    /**
     * @param mixed $requestData
     * @return object
     */
    public function updateUserById($requestData);

     /**
     * @param mixed $username
     * @return object
     */
    public function findUserByUsername($username);

    /**
     * register customer
     * @param $requestData
     */
    public function create($requestData);

    /**
     * Logout customer
     * @param $requestData
     */
    public function logout($requestData);

    /**
     * following customer
     * @param $userId, $followingId
     */
    public function follow($userId, $followingId);

    /**
     * un follow
     * @param $userId, $followingId
     */
    public function unFollow($userId, $followingId);

    /**
     * upload avatar image
     * @param mixed $name
     */
    public function uploadAvatar(Request $request);


    public function recommendFollow();

}
