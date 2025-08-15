<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "user_id",
        "description",
        "date_start",
        "date_end",
        "location",
        "price",
        "image",
        "category_id",
        "status",
        "visibility",
        "rejection_reason",
        "approved_at",
        "approved_by",
    ];

    protected $casts = [
        'date_start' => 'datetime',
        'date_end' => 'datetime',
        'price' => 'decimal:2',
        'approved_at' => 'datetime',
    ];




    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tickets(){
        return $this->hasMany(Tickets::class, 'event_id');
    }

    public function approvedBy(){
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class, 'event_id');
    }

    // Scopes for filtering events
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Visibility scopes
    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

    public function scopePrivate($query)
    {
        return $query->where('visibility', 'private');
    }

    public function scopeMembersOnly($query)
    {
        return $query->where('visibility', 'members_only');
    }

    public function scopeVisibleTo($query, $user = null)
    {
        if (!$user) {
            // Guest users can only see public events
            return $query->where('visibility', 'public');
        }

        // Logged-in users can see public and private events
        // For members_only, you might want to add additional logic
        return $query->whereIn('visibility', ['public', 'private']);
    }

    // Helper methods for visibility
    public function isPublic()
    {
        return $this->visibility === 'public';
    }

    public function isPrivate()
    {
        return $this->visibility === 'private';
    }

    public function isMembersOnly()
    {
        return $this->visibility === 'members_only';
    }

    // Get average rating for this event
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    // Get total number of reviews
    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }

    // Check if user can review this event (has attended and hasn't reviewed yet)
    public function canUserReview($userId)
    {
        // Check if user has a ticket for this event and event has ended
        $hasTicket = $this->tickets()->where('user_id', $userId)->exists();
        $eventEnded = $this->date_end < now();
        $hasReviewed = $this->reviews()->where('user_id', $userId)->exists();

        return $hasTicket && $eventEnded && !$hasReviewed;
    }
}
