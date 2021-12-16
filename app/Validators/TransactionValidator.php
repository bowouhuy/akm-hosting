<?php

namespace App\Validators;

use App\Validators\Contracts\ValidatorContracts;

class TransactionValidator implements ValidatorContracts
{

    public static function ins()
    {
        return new self();
    }

    public function rules($id): array
    {
        $unique = $id ? ',' . $id . ',id' : '';
        return [
            'id' => 'required|string|unique:transactions,id' . $unique,
            'user_id' => 'required',
            'amount' => 'required|integer',
            'date' => 'required',
        ];
    }
}
