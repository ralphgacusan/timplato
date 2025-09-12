<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $table = 'support_tickets'; // Table name

    protected $primaryKey = 'ticket_id';

    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'status',
    ];

    /**
     * Ticket belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
