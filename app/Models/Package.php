<?php

namespace App\Models;

use App\Validators\PackageValidator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Package extends Model
{
    use HasFactory;
    protected $table = 'packages';
    protected $primaryKey = 'id';
    protected $fillable = ['id','name','description','price'];
    
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
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);
    }

    public function questions()
    {   
        return $this->hasMany(Question::class, 'package_id');
    }

    public function exams()
    {   
        return $this->hasMany(Exam::class, 'package_id');
    }
}
