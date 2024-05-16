<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizOrder extends Model
{
    protected $table='quiz_orders';
    protected $attributes = [
        'is_paid' => 0,
    ];
protected $fillable=[
    'quizz_id'
];


    public function quizz()
    {
        // Assuming you have a Quiz model
        return $this->belongsTo(Quizz::class);
    }
}

