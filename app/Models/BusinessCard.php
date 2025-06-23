<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessCard extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'title',
        'bio',
        'avatar',
        'theme',
        'backgroundColor',
        'textColor',
        'accentColor',
        'phone',
        'email',
        'links',
        'visibility'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'links' => 'array',
        'visibility' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the business card.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include visible cards.
     */
    public function scopeVisible($query)
    {
        return $query->where('visibility', true);
    }

    /**
     * Scope a query to only include cards for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get the full URL for the card's avatar.
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar && !str_starts_with($this->avatar, 'http')) {
            return asset($this->avatar);
        }
        return $this->avatar;
    }

    /**
     * Get the public URL for this card.
     */
    public function getPublicUrlAttribute()
    {
        return route('cards.show', $this->id);
    }
}