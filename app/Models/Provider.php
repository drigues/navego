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
        'business_name',
        'slug',
        'description',
        'logo',
        'website',
        'nif',
        'address',
        'city',
        'district',
        'postal_code',
        'phone',
        'whatsapp',
        'contact_email',
        'languages',
        'social_links',
        'working_hours',
        'serves_remote',
        'is_verified',
        'is_active',
        'rating',
        'reviews_count',
        'plan',
    ];

    protected function casts(): array
    {
        return [
            'languages' => 'array',
            'social_links' => 'array',
            'working_hours' => 'array',
            'serves_remote' => 'boolean',
            'is_verified' => 'boolean',
            'is_active' => 'boolean',
            'rating' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    public function activeServices(): HasMany
    {
        return $this->hasMany(Service::class)->where('is_active', true);
    }
}
