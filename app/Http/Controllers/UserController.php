<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\UserContract;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    protected $name = 'User',
        $repository,
        $redirectTo = '/participant',
        $layout = 'participant';

    public function __construct(
        UserContract $contract)
    {
        $this->middleware('auth.admin');
        $this->repository = $contract;
    }
}