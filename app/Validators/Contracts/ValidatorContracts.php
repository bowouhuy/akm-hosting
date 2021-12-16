<?php

namespace App\Validators\Contracts;


interface ValidatorContracts
{
    public static function ins();
    public function rules($id): array;
}
