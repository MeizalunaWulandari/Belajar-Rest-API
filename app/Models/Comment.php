<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function commentator(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id', 'id');
    }
}
