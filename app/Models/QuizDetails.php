<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'quizz_id',
        'question_id',
        'user_answer',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quizz::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}
