<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'provider_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price_min',
        'price_max',
        'price_unit',
        'currency',
        'tags',
        'is_active',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'is_active' => 'boolean',
            'price_min' => 'decimal:2',
            'price_max' => 'decimal:2',
        ];
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
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
