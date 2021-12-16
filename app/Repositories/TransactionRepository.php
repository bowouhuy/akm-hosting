<?php

namespace App\Repositories;


use App\Models\Transaction;
use App\Repositories\Contracts\TransactionContract;

class TransactionRepository extends Repository implements TransactionContract
{
    public function getModel()
    {
        return Transaction::ins();
    }

}
