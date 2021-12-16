<?php

namespace App\Models;

use App\Validators\QuestionTypeValidator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class QuestionType extends Model
{
    use HasFactory;
    protected $table = 'question_types';
    protected $primaryKey = 'id';
    protected $fillable = ['id','name'];
    
    public static function ins()
    {
        return new self();
    }

    public function getValidator()
    {
        return QuestionTypeValidator::ins();
    }

    public function pop(Request $request)
    {
        return $this->fill([
            'id' => $request->id,
            'name' => $request->name,
        ]);
    }

    public function questions()
    {   
        return $this->hasMany(Question::class, 'type_id');
    }
}
