<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function ticketReplies()
    {
        $this->hasMany(TicketReply::class);
    }

}
