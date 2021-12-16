<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\TransactionContract;
use App\Models\Transaction;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionController extends BaseController
{
    protected $name = 'Transaction',
        $repository,
        $redirectTo = '/transaction',
        $layout = 'transaction';

    public function __construct(
        TransactionContract $contract)
    {
        $this->middleware('auth.admin');
        $this->repository = $contract;
    }

    public function fetchCustomDatatable(){
        try {
            $list = Transaction::with('user')->get()->toArray();
            
            $dt = Datatables::collection($list)
                ->toArray();
            
            $json = preg_replace('/{"EMPTY_OBJECT"\s*:\s*true}/',
                '{}',
                json_encode($dt, JSON_UNESCAPED_SLASHES));
            
            return $json;

        } catch (\Exception $e) {
            return back()
                ->withErrors(
                    $e->__toString()
                );
        }
    }
}