<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $table = 'answers';
    protected $primaryKey = 'id';
    protected $fillable = ['id','question_id','answer','answer_key'];

    public function question()
    {   
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function exam_detail()
    {   
        return $this->hasMany(ExamDetail::class, 'answer_id');
    }
}
