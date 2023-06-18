<?php
namespace App\Repositories\Interfaces;

Interface UserRepositoryInterface{
    
    /**
     * get user by username
     * @param mixed $username
     */
    public function getUserByUsername($username);
}