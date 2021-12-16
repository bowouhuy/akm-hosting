<?php

namespace App\Models;

use App\Validators\ExamValidator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Exam extends Model
{
    use HasFactory;
    protected $table = 'exams';
    protected $primaryKey = 'id';
    protected $fillable = ['id','user_id','package_id','total_question','exam_start','exam_end','exam_date',
    'status','result','score'];
    
    public static function ins()
    {
        return new self();
    }

    public function getValidator()
    {
        return ExamValidator::ins();
    }

    public function pop(Request $request)
    {
        return $this->fill([
            'id' => $request->id,
            'user_id' => $request->user_id,
            'package_id' => $request->package_id,
            'total_question' => $request->total_question,
            'exam_start' => $request->exam_start,
            'exam_end' => $request->exam_end,
            'exam_date' => $request->exam_date,
            'status' => $request->status,
            'result' => $request->result,
            'score' => $request->score
        ]);
    }

    public function user()
    {   
        return $this->belongsTo(User::class, 'user_id');
    }

    public function package()
    {   
        return $this->belongsTo(Package::class, 'package_id');
    }
    
    public function details()
    {   
        return $this->hasMany(ExamDetail::class, 'exam_id')->orderBy('question_no','asc');
    }
}
