<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "event_id",
        "ticket_type",
        "price",
        "quantity",
        "total_amount",
        "pdf",
        "is_paid",
        "payment_method",
        "stripe_session_id",
        "purchased_at",
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'purchased_at' => 'datetime',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function event(){
        return $this->belongsTo(Events::class, 'event_id');
    }
    

}
