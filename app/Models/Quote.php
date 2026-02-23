<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'provider_id',
        'service_id',
        'title',
        'description',
        'budget_min',
        'budget_max',
        'currency',
        'status',
        'provider_response',
        'proposed_price',
        'responded_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'budget_min' => 'decimal:2',
            'budget_max' => 'decimal:2',
            'proposed_price' => 'decimal:2',
            'responded_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_VIEWED = 'viewed';
    const STATUS_REPLIED = 'replied';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_REJECTED = 'rejected';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
