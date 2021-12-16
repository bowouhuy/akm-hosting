<?php

namespace App\Models;

use App\Validators\QuestionValidator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Question extends Model
{
    use HasFactory;
    protected $table = 'questions';
    protected $primaryKey = 'id';
    protected $fillable = ['id','package_id','type_id','question'];
    // protected $casts = [
    //     'question' => 'string'
    // ];
    
    public static function ins()
    {
        return new self();
    }

    public function getValidator()
    {
        return QuestionValidator::ins();
    }

    public function pop(Request $request)
    {
        return $this->fill([
            'id' => $request->id,
            'package_id' => $request->package_id,
            'type_id' => $request->type_id,
            'question' => $request->question
        ]);
    }

    public function answers()
    {   
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function package()
    {   
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function type()
    {   
        return $this->belongsTo(QuestionType::class, 'type_id');
    }

    public function exam_detail()
    {   
        return $this->hasMany(ExamDetail::class, 'question_id');
    }
}
