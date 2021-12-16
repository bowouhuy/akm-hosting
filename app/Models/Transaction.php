<?php

namespace App\Models;

use App\Validators\TransactionValidator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $fillable = ['id','user_id','date','amount','status'];
    
    public static function ins()
    {
        return new self();
    }

    public function getValidator()
    {
        return TransactionValidator::ins();
    }

    public function pop(Request $request)
    {
        return $this->fill([
            'id' => $request->id,
            'user_id' => $request->user_id,
            'date' => $request->date,
            'amount' => $request->amount,
            'status' => $request->status
        ]);
    }

    public function user()
    {   
        return $this->belongsTo(User::class, 'user_id');
    }
}
