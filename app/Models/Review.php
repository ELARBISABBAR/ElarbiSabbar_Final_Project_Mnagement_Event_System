<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'rating',
        'comment',
        'is_verified',
        'attended_at',
    ];

    protected $casts = [
        'attended_at' => 'datetime',
        'is_verified' => 'boolean',
        'rating' => 'integer',
    ];

    /**
     * Get the event that this review belongs to.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Events::class);
    }

    /**
     * Get the user who wrote this review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get only verified reviews (from users who actually attended).
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope to get reviews by rating.
     */
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Get star rating as array for display.
     */
    public function getStarsAttribute()
    {
        return [
            'filled' => $this->rating,
            'empty' => 5 - $this->rating
        ];
    }
}
