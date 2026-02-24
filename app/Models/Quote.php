<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'name',
        'email',
        'phone',
        'description',
        'budget_range',
        'deadline',
        'status',
    ];

    const STATUS_NEW    = 'new';
    const STATUS_VIEWED = 'viewed';
    const STATUS_REPLIED = 'replied';
    const STATUS_CLOSED = 'closed';

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
