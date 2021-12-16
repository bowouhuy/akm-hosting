<?php

namespace App\Repositories;


use App\Models\Wallet;
use App\Repositories\Contracts\WalletContract;

class WalletRepository extends Repository implements WalletContract
{
    public function getModel()
    {
        return Wallet::ins();
    }

}
