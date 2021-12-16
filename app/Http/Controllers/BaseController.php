<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\RestController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

abstract class BaseController extends Controller
{
    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        RestController;

    protected $request,
        $repository,
        $name = "Controller",
        $layout = 'src',
        $service,
        $redirectTo = '/';
}
