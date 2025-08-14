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
    ];

    protected $casts = [
        'date_start' => 'datetime',
        'date_end' => 'datetime',
        'price' => 'decimal:2',
    ];




    public function user(){
        return $this->belongsTo(User::class);
    }
    public function tickets(){
        return $this->hasMany(Tickets::class, 'event_id');
    }
}
