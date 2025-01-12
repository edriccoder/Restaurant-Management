<?php

namespace App\Models\Food;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class checkout extends Model
{
    use HasFactory;

    protected $table = "checkout";


    protected $fillable = [
        'name',
        'email',
        'town',
        'country',
        'zipcode',
        'phonenumber',
        'address',
        'user_id',
        'price',
        'status',
    ];

    public $timestamps = true;
}
