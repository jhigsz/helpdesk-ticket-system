<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    // Only these fields can be mass-assigned.
    // user_id is deliberately excluded for security.
    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'category',
    ];

    // A ticket belongs to one user.
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
