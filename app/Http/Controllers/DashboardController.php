<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\DashboardContract;
use Illuminate\Http\Request;

// class DashboardController extends BaseController
// {
//     protected $name = 'Dashboard',
//         $repository,
//         $redirectTo = '/dashboard',
//         $layout = 'dashboard';

//     public function __construct(
//         DashboardContract $contract)
//     {
//         $this->repository = $contract;
//     }
// }

class DashboardController extends Controller
{
    protected $title = 'Dashboard';
    protected $breadcrumbs;

    public function __construct()
    {
        $this->middleware('auth.admin');
        $this->breadcrumbs = [
            ['name'=> $this->title]
        ];
    }

    public function index() {
        $data = [
            'breadcrumbs' => $this->breadcrumbs
        ];
        return view('dashboard.index', $data);
    }
}
