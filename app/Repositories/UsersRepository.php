<?php
namespace App\Repositories;

use App\Models\User;

class UsersRepository {

    public function register($data){

        return User::create($data);
    }
}
