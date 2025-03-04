<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'podcast_id',
        'amount',
        'payment_status',
        'transaction_id'
    ];

    /**
     * Relation avec l'utilisateur (un paiement appartient à un utilisateur)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le podcast (un paiement concerne un podcast)
     */
    public function podcast()
    {
        return $this->belongsTo(Podcast::class);
    }
}
