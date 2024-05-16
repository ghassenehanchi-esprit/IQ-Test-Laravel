<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'difficulty_level',
        'score',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
