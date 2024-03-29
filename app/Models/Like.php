<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Retsept;
use App\Models\User;

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes';

    protected $fillable = [
        'user_id',
        'retsept_id',
        'ball',
    ];

    public function retsept(): BelongsTo
    {
        return $this->belongsTo(Retsept::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
