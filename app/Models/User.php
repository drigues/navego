<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'google_avatar',
        'phone',
        'avatar',
        'nationality',
        'document_type',
        'document_number',
        'preferred_language',
        'bio',
        'city',
        'district',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function provider(): HasOne
    {
        return $this->hasOne(Provider::class);
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    public function guides(): HasMany
    {
        return $this->hasMany(Guide::class, 'author_id');
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'author_id');
    }
}
