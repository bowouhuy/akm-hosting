<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PackageContract;
use Illuminate\Http\Request;

class PackageController extends BaseController
{
    protected $name = 'Package',
        $repository,
        $redirectTo = '/package',
        $layout = 'package';

    public function __construct(
        PackageContract $contract)
    {
        $this->middleware('auth.admin');
        $this->repository = $contract;
    }
}