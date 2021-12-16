<?php

namespace App\Models\Contracts;

use Illuminate\Http\Request;

interface BaseModelContract
{
    public static function ins();
    public function getValidator();
    public function pop(Request $request);
}
