<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Ntar Ganti setelah create jalan
    public function writer() : BelongsTo
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }
}
