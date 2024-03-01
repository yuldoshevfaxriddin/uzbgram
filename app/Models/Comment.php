<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Retsept;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [
        'retsept_id',
        'user_id',
        'description',
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
