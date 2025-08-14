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
        "pdf",
        "is_paid",
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function event(){
        return $this->belongsTo(Events::class, 'event_id');
    }
    

}
