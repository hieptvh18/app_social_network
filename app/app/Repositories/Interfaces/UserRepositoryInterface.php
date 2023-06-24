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
     * @param $requestData
     */
    public function follow($requestData);
}
