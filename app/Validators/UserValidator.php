<?php

namespace App\Validators;

use App\Validators\Contracts\ValidatorContracts;

class UserValidator implements ValidatorContracts
{

    public static function ins()
    {
        return new self();
    }

    public function rules($id): array
    {
        $unique = $id ? ',' . $id . ',id' : '';
        return [
            'id' => 'required|string|unique:users,id' . $unique,
            'username' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string|confirmed',
            'role' => 'required',
        ];
    }
}
