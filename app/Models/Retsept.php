<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retsept extends Model
{
    use HasFactory;

    protected $table = 'retsepts';

    protected $fillable = [
        'name',
        'user_id',
        'message',
        'image',
    ];
}
