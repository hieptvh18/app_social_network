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
    public function updateUserByUsername($requestData);

     /**
     * @param mixed $username
     * @return object
     */
    public function findUserByUsername($username);
}