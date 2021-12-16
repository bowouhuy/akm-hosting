<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\WalletContract;
use App\Models\Wallet;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WalletController extends BaseController
{
    protected $name = 'Wallet',
        $repository,
        $redirectTo = '/wallet',
        $layout = 'wallet';

    public function __construct(
        WalletContract $contract)
    {
        $this->middleware('auth.admin');
        $this->repository = $contract;
    }

    public function fetchCustomDatatable(){
        try {
            $list = Wallet::with('user')->get()->toArray();
            
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

    public function getWalletDetails($id){
        try {
            $data = Wallet::with('details')->findOrFail($id);

            return $this->json(
                Response::HTTP_OK,
                "Answer Fetched.",
                $data
            );
        } catch (\Exception $e) {
            throw $e;
        }
    }
}