<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Validators\UserValidator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function ins()
    {
        return new self();
    }

    public function getValidator()
    {
        return PackageValidator::ins();
    }

    public function pop(Request $request)
    {
        return $this->fill([
            'id' => $request->id,
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);
    }

    public function wallets()
    {   
        return $this->hasMany(Wallet::class, 'user_id');
    }

    public function answers()
    {   
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function exams()
    {   
        return $this->hasMany(Transaction::class, 'user_id');
    }
}
