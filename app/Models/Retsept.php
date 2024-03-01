<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function comments(): HasMany
    {
        return $this->hasMany(Izoh::class);
    }
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

}
