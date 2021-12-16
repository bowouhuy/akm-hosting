<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletDetail extends Model
{
    use HasFactory;
    protected $table = 'wallet_details';
    protected $primaryKey = 'id';
    protected $fillable = ['id','wallet_id','transaction_id','amount','type','date'];

    public function wallet()
    {   
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }
}
