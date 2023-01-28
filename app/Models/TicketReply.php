<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketReply extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ticket_replies';

    public function ticket()
    {
        $this->belongsTo(Ticket::class);
    }

}
