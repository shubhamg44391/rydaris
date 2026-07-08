<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = [
        'user_id',
        'vendor_id',
        'ticket_number',
        'subject',
        'message',
        'category',
        'priority',
        'status',
        'attachment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function replies()
    {
        return $this->hasMany(SupportTicketReply::class, 'support_ticket_id');
    }
}
