<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'business_name',
        'slug',
        'description',
        'logo',
        'phone',
        'address',
        'city',
        'website',
        'instagram',
        'whatsapp',
        'plan',
        'status',
        'views_count',
        'quotes_count',
    ];

    const PLAN_BASIC = 'basic';
    const PLAN_PRO   = 'pro';

    const STATUS_PENDING  = 'pending';
    const STATUS_ACTIVE   = 'active';
    const STATUS_REJECTED = 'rejected';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }
}
