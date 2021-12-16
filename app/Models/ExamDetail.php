<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamDetail extends Model
{
    use HasFactory;
    protected $table = 'exam_details';
    protected $primaryKey = 'id';
    protected $fillable = ['id','exam_id','question_id','answer_id','question_no','answer_status'];

    public function exam()
    {   
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function question()
    {   
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function answer()
    {   
        return $this->belongsTo(Answer::class, 'answer_id');
    }
}
