<?php

namespace App\Models;

use App\Validators\WalletValidator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Wallet extends Model
{
    use HasFactory;
    protected $table = 'wallets';
    protected $primaryKey = 'id';
    protected $fillable = ['id','name','description','price'];
    
    public static function ins()
    {
        return new self();
    }

    public function getValidator()
    {
        return WalletValidator::ins();
    }

    public function pop(Request $request)
    {
        return $this->fill([
            'id' => $request->id,
            'user_id' => $request->user_id,
            'amount' => $request->amount
        ]);
    }

    public function user()
    {   
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {   
        return $this->hasMany(WalletDetail::class, 'wallet_id')->orderBy('date','desc');
    }
}
