<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_text',
        'question_image',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function quizDetails()
    {
        return $this->hasMany(QuizDetails::class);
    }
}
