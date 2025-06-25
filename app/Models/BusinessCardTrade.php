<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessCardTrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id', 'receiver_id', 'card_id', 'status'
    ];

    // 送信者
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // 受信者
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // ビジネスカード
    public function card()
    {
        return $this->belongsTo(BusinessCard::class, 'card_id');
    }
}