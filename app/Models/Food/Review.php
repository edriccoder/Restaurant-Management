<?php

namespace App\Models\Food;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $table = "reviews";

    protected $fillable = [
        'name',
        'review',
    ];
}
