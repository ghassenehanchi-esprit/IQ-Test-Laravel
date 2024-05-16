<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'quizz_id',
        'payment_method',
        'is_paid',
        'certif',
    ];

    public function quizz()
    {
        return $this->belongsTo(Quizz::class);
    }
}
