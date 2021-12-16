<?php

namespace App\Repositories;


use App\Models\User;
use App\Repositories\Contracts\UserContract;

class UserRepository extends Repository implements UserContract
{
    public function getModel()
    {
        return User::ins();
    }

}
