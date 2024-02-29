<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izoh extends Model
{
    use HasFactory;

    protected $table = 'izohs'; 

    protected $fillable = [
        'retsept_id',
        'user_id',
        'description',
    ];  
}
