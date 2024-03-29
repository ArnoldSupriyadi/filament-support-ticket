<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'response',
        'send_to',
        'sent_by',
        'status',
        'remarks',
    ];

    CONST STATUS = [
        "PENDING" => "PENDING",
        "SUCCESS" => "SUCCESS",
        "FAILED" => "FAILED",
    ];

    public function sentTo()
    {
        return $this->belongsTo(User::class, 'sent_to');
    }

    public function sentBy()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }
}
